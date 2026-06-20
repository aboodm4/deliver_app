import http from "k6/http";
import { check } from "k6";
import { Counter, Rate, Trend } from "k6/metrics";

/*
|--------------------------------------------------------------------------
| Environment variables
|--------------------------------------------------------------------------
|
| مثال التشغيل:
|
| k6 run `
|   -e BASE_URL=http://127.0.0.1:8080/api `
|   -e TOKEN=YOUR_TOKEN `
|   -e API_VERSION=old `
|   -e PRODUCT_ID=1 `
|   -e QUANTITY=1 `
|   tests/k6/inventory_concurrency_test.js
|
*/

const BASE_URL = __ENV.BASE_URL || "http://127.0.0.1:8080/api";
const TOKEN = __ENV.TOKEN || "";
const API_VERSION = (__ENV.API_VERSION || "new").toLowerCase();
const PRODUCT_ID = Number(__ENV.PRODUCT_ID || 1);
const QUANTITY = Number(__ENV.QUANTITY || 1);

/*
|--------------------------------------------------------------------------
| Custom metrics
|--------------------------------------------------------------------------
*/

const successfulDeductions = new Counter("successful_deductions");
const insufficientStockResponses = new Counter("insufficient_stock_responses");
const lockTimeoutResponses = new Counter("lock_timeout_responses");
const unexpectedResponses = new Counter("unexpected_responses");

const businessFailureRate = new Rate("business_failure_rate");
const apiDuration = new Trend("inventory_api_duration", true);

/*
|--------------------------------------------------------------------------
| Load configuration
|--------------------------------------------------------------------------
|
| exactly 100 concurrent virtual users
| each VU executes one request
|
*/

export const options = {
    scenarios: {
        inventory_concurrency: {
            executor: "per-vu-iterations",
            vus: 100,
            iterations: 1,
            maxDuration: "60s",
        },
    },

    thresholds: {
        http_req_failed: ["rate<0.05"],
        http_req_duration: ["p(95)<3000"],
        inventory_api_duration: ["p(95)<3000"],
        business_failure_rate: ["rate<0.05"],
    },
};

/*
|--------------------------------------------------------------------------
| Select old or new endpoint
|--------------------------------------------------------------------------
*/

function getEndpoint() {
    if (API_VERSION === "old") {
        return `${BASE_URL}/product/minus-product`;
    }

    return `${BASE_URL}/v2/product/minus-product`;
}

/*
|--------------------------------------------------------------------------
| Test execution
|--------------------------------------------------------------------------
*/

export default function () {
    if (!TOKEN) {
        throw new Error("TOKEN environment variable is required.");
    }

    const payload = JSON.stringify({
        product_id: PRODUCT_ID,
        quantity: QUANTITY,
    });

    const params = {
        headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
            Authorization: `Bearer ${TOKEN}`,
        },

        tags: {
            api_version: API_VERSION,
            endpoint: "minus-product",
        },

        timeout: "15s",
    };

    const startedAt = Date.now();

    const response = http.post(getEndpoint(), payload, params);

    apiDuration.add(Date.now() - startedAt, {
        api_version: API_VERSION,
    });

    /*
    |--------------------------------------------------------------------------
    | Response classification
    |--------------------------------------------------------------------------
    |
    | 200: stock was deducted successfully
    | 409: stock is finished; expected business rejection
    | 429: distributed lock timeout; safe overload rejection
    | Other: unexpected application or infrastructure failure
    |
    */

    if (response.status === 200) {
        successfulDeductions.add(1);
        businessFailureRate.add(false);
    } else if (response.status === 409) {
        insufficientStockResponses.add(1);
        businessFailureRate.add(false);
    } else if (response.status === 429) {
        lockTimeoutResponses.add(1);
        businessFailureRate.add(false);
    } else {
        unexpectedResponses.add(1);
        businessFailureRate.add(true);
    }

    check(response, {
        "response is a recognized result": (res) =>
            [200, 409, 429].includes(res.status),

        "response is JSON": (res) =>
            (res.headers["Content-Type"] || "")
                .toLowerCase()
                .includes("application/json"),

        "instance header exists": (res) =>
            Boolean(res.headers["X-App-Instance"]),

        "performance header exists": (res) =>
            Boolean(res.headers["X-Aop-Duration-Ms"]),
    });
}
