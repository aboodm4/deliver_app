import http from 'k6/http';
import { check, sleep } from 'k6';

export const options = {
    vus: 20, // 20 virtual users
    duration: '15s', // 15 seconds test
};

// Expecting environment variables:
// K6_TOKEN: Bearer token for authentication
// K6_VERSION: v1 or v2

export default function () {
    const token = __ENV.K6_TOKEN;
    const version = __ENV.K6_VERSION || 'v1';
    
    if (!token) {
        console.error("Please provide a token using -e K6_TOKEN=your_token");
        return;
    }

    const baseUrl = "http://127.0.0.1:8080/api";
    
    const params = {
        headers: {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
    };

    let url = version === 'v2' ? `${baseUrl}/v2/order` : `${baseUrl}/order`;
    let res = http.get(url, params);

    check(res, {
        'orders fetched successfully': (r) => r.status === 200,
    });
}
