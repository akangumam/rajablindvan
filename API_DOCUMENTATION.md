# Raja Fleet Monitor - API Documentation

Base URL: `https://rajafleet.khaerulumam.id/api/v1`

## Authentication

All endpoints (except login) require Bearer token authentication.

### Headers

```
Authorization: Bearer {your_token}
Accept: application/json
Content-Type: application/json
```

---

## 🔐 Authentication Endpoints

### 1. Login

**POST** `/login`

Request body:

```json
{
    "email": "admin@rajablindvan.com",
    "password": "admin123",
    "device_name": "Flutter Mobile App"
}
```

Success Response (200):

```json
{
    "success": true,
    "message": "Login successful",
    "data": {
        "user": {
            "id": 1,
            "name": "Administrator",
            "email": "admin@rajablindvan.com",
            "role": "super_admin",
            "location": {
                "id": 1,
                "name": "Jakarta"
            }
        },
        "token": "1|abcdef123456..."
    }
}
```

Error Response (422):

```json
{
    "message": "The provided credentials are incorrect.",
    "errors": {
        "email": ["The provided credentials are incorrect."]
    }
}
```

### 2. Logout

**POST** `/logout`

Headers: `Authorization: Bearer {token}`

Success Response (200):

```json
{
    "success": true,
    "message": "Logged out successfully"
}
```

### 3. Get Current User

**GET** `/me`

Headers: `Authorization: Bearer {token}`

Success Response (200):

```json
{
    "success": true,
    "data": {
        "id": 1,
        "name": "Administrator",
        "email": "admin@rajablindvan.com",
        "role": "super_admin",
        "phone": "081234567890",
        "location": {
            "id": 1,
            "name": "Jakarta"
        },
        "is_active": true
    }
}
```

---

## 📊 Dashboard Endpoints

### 1. Get Dashboard Statistics

**GET** `/dashboard`

Success Response (200):

```json
{
    "success": true,
    "data": {
        "vehicles": {
            "total": 12,
            "available": 5,
            "rented": 6,
            "maintenance": 1
        },
        "rentals": {
            "active": 6,
            "overdue": 2
        },
        "financial": {
            "monthly_revenue": 45000000,
            "monthly_expenses": 12000000,
            "net_income": 33000000
        },
        "alerts": {
            "upcoming_maintenance": 3,
            "overdue_rentals": 2
        },
        "location_stats": [
            {
                "location": "Jakarta",
                "total_vehicles": 7
            },
            {
                "location": "Malang",
                "total_vehicles": 5
            }
        ],
        "recent_activities": [
            {
                "type": "rental",
                "title": "Rental Created",
                "description": "John Doe rented Toyota Hiace",
                "vehicle": "B 1234 XYZ",
                "time": "2 hours ago",
                "timestamp": "2025-11-04T10:30:00Z"
            }
        ]
    }
}
```

### 2. Get Monthly Revenue Chart

**GET** `/dashboard/monthly-revenue`

Success Response (200):

```json
{
    "success": true,
    "data": {
        "labels": [
            "Jun 2025",
            "Jul 2025",
            "Aug 2025",
            "Sep 2025",
            "Oct 2025",
            "Nov 2025"
        ],
        "values": [35000000, 42000000, 38000000, 45000000, 48000000, 45000000]
    }
}
```

---

## 🚗 Vehicle Endpoints

### 1. Get All Vehicles

**GET** `/vehicles`

Query Parameters:

-   `status` (optional): available, rented, maintenance
-   `location_id` (optional, admin only): 1, 2, etc.
-   `search` (optional): Search by license plate, brand, or model
-   `page` (optional): Pagination page number

Success Response (200):

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "brand": "Toyota",
            "model": "Hiace",
            "license_plate": "B 1234 XYZ",
            "year": 2022,
            "color": "White",
            "status": "available",
            "capacity": 14,
            "daily_rate": 850000,
            "hourly_rate": 125000,
            "location": {
                "id": 1,
                "name": "Jakarta"
            },
            "fuel_type": "Diesel",
            "transmission": "Manual",
            "odometer": 45000,
            "last_maintenance": "2025-10-15",
            "next_maintenance": "2025-12-15",
            "image_url": "https://rajafleet.khaerulumam.id/storage/vehicles/hiace.jpg"
        }
    ],
    "meta": {
        "current_page": 1,
        "last_page": 2,
        "per_page": 20,
        "total": 25
    }
}
```

### 2. Get Vehicle Details

**GET** `/vehicles/{id}`

Success Response (200):

```json
{
    "success": true,
    "data": {
        "id": 1,
        "brand": "Toyota",
        "model": "Hiace",
        "license_plate": "B 1234 XYZ",
        "year": 2022,
        "color": "White",
        "status": "available",
        "capacity": 14,
        "daily_rate": 850000,
        "hourly_rate": 125000,
        "location": {
            "id": 1,
            "name": "Jakarta"
        },
        "fuel_type": "Diesel",
        "transmission": "Manual",
        "odometer": 45000,
        "last_maintenance": "2025-10-15",
        "next_maintenance": "2025-12-15",
        "insurance_expiry": "2026-05-20",
        "registration_expiry": "2026-03-15",
        "image_url": "https://rajafleet.khaerulumam.id/storage/vehicles/hiace.jpg",
        "description": "14-seater comfortable van",
        "features": "AC, Audio System, GPS",
        "statistics": {
            "total_rentals": 45,
            "active_rentals": 0,
            "total_revenue": 38250000,
            "total_maintenance_cost": 5600000
        },
        "created_at": "2025-01-15T08:00:00Z",
        "updated_at": "2025-11-04T10:30:00Z"
    }
}
```

### 3. Get Vehicle Rental History

**GET** `/vehicles/{id}/rentals`

Success Response (200):

```json
{
    "success": true,
    "data": [
        {
            "id": 15,
            "customer": {
                "name": "John Doe",
                "phone": "081234567890"
            },
            "start_date": "2025-11-01 08:00",
            "end_date": "2025-11-05 18:00",
            "status": "completed",
            "rental_type": "daily",
            "total_days": 4,
            "total_price": 3400000,
            "created_at": "3 days ago"
        }
    ],
    "meta": {
        "current_page": 1,
        "last_page": 5,
        "total": 45
    }
}
```

### 4. Get Vehicle Maintenance History

**GET** `/vehicles/{id}/maintenances`

Success Response (200):

```json
{
    "success": true,
    "data": [
        {
            "id": 8,
            "type": "Oil Change",
            "description": "Engine oil change and filter replacement",
            "cost": 850000,
            "date": "2025-10-15",
            "due_date": "2025-12-15",
            "status": "completed",
            "odometer_reading": 45000,
            "service_provider": "Auto Service Center",
            "created_at": "20 days ago"
        }
    ],
    "meta": {
        "current_page": 1,
        "last_page": 3,
        "total": 28
    }
}
```

---

## 📋 Rental Endpoints

### 1. Get All Rentals

**GET** `/rentals`

Query Parameters:

-   `status` (optional): active, completed, cancelled
-   `location_id` (optional, admin only): Filter by location
-   `page` (optional): Pagination

Success Response (200):

```json
{
    "success": true,
    "data": [
        {
            "id": 25,
            "vehicle": {
                "brand": "Toyota",
                "model": "Hiace",
                "license_plate": "B 1234 XYZ"
            },
            "customer": {
                "name": "John Doe",
                "phone": "081234567890"
            },
            "start_date": "2025-11-04 08:00",
            "end_date": "2025-11-08 18:00",
            "status": "active",
            "rental_type": "daily",
            "total_days": 4,
            "total_price": 3400000,
            "is_overdue": false,
            "created_at": "6 hours ago"
        }
    ],
    "meta": {
        "current_page": 1,
        "last_page": 5,
        "per_page": 20,
        "total": 95
    }
}
```

### 2. Get Active Rentals Only

**GET** `/rentals/active`

Success Response (200):

```json
{
    "success": true,
    "data": [
        {
            "id": 25,
            "vehicle": {
                "brand": "Toyota",
                "model": "Hiace",
                "license_plate": "B 1234 XYZ"
            },
            "customer": {
                "name": "John Doe",
                "phone": "081234567890"
            },
            "start_date": "2025-11-04 08:00",
            "end_date": "2025-11-08 18:00",
            "status": "active",
            "rental_type": "daily",
            "total_days": 4,
            "total_price": 3400000,
            "days_remaining": 4,
            "is_overdue": false,
            "created_at": "6 hours ago"
        }
    ]
}
```

### 3. Get Rental Details

**GET** `/rentals/{id}`

Success Response (200):

```json
{
    "success": true,
    "data": {
        "id": 25,
        "vehicle": {
            "id": 1,
            "brand": "Toyota",
            "model": "Hiace",
            "license_plate": "B 1234 XYZ",
            "color": "White",
            "location": "Jakarta"
        },
        "customer": {
            "id": 15,
            "name": "John Doe",
            "phone": "081234567890",
            "email": "john@example.com",
            "address": "Jl. Sudirman No. 123, Jakarta"
        },
        "start_date": "2025-11-04 08:00",
        "end_date": "2025-11-08 18:00",
        "status": "active",
        "rental_type": "daily",
        "total_days": 4,
        "rate": 850000,
        "total_price": 3400000,
        "deposit": 1000000,
        "pickup_location": "Jakarta Office",
        "dropoff_location": "Jakarta Office",
        "notes": "Customer preferred morning pickup",
        "is_overdue": false,
        "days_remaining": 4,
        "created_at": "2025-11-04T02:00:00Z",
        "updated_at": "2025-11-04T02:00:00Z"
    }
}
```

---

## ⚠️ Error Responses

### 401 Unauthorized

```json
{
    "message": "Unauthenticated."
}
```

### 403 Forbidden

```json
{
    "success": false,
    "message": "You do not have access to this resource"
}
```

### 404 Not Found

```json
{
    "success": false,
    "message": "Resource not found"
}
```

### 422 Validation Error

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email": ["The email field is required."]
    }
}
```

---

## 📱 Flutter Integration Example

```dart
// lib/services/api_service.dart
import 'package:dio/dio.dart';

class ApiService {
  final Dio dio = Dio(BaseOptions(
    baseUrl: 'https://rajafleet.khaerulumam.id/api/v1',
    connectTimeout: Duration(seconds: 5),
    receiveTimeout: Duration(seconds: 3),
  ));

  Future<Response> login(String email, String password) async {
    return await dio.post('/login', data: {
      'email': email,
      'password': password,
      'device_name': 'Flutter Mobile App',
    });
  }

  Future<Response> getDashboard(String token) async {
    return await dio.get('/dashboard',
      options: Options(headers: {'Authorization': 'Bearer $token'}),
    );
  }

  Future<Response> getVehicles(String token, {String? status}) async {
    return await dio.get('/vehicles',
      queryParameters: status != null ? {'status': status} : null,
      options: Options(headers: {'Authorization': 'Bearer $token'}),
    );
  }
}
```

---

## 🔧 Testing with cURL

### Login

```bash
curl -X POST https://rajafleet.khaerulumam.id/api/v1/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@rajablindvan.com","password":"admin123","device_name":"Test"}'
```

### Get Dashboard (with token)

```bash
curl -X GET https://rajafleet.khaerulumam.id/api/v1/dashboard \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Accept: application/json"
```

### Get Vehicles

```bash
curl -X GET "https://rajafleet.khaerulumam.id/api/v1/vehicles?status=available" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Accept: application/json"
```

---

## 📝 Notes

1. **Token Storage**: Store token securely using `flutter_secure_storage`
2. **Token Expiry**: Tokens don't expire by default, but can be revoked on logout
3. **Pagination**: Most list endpoints support pagination with `page` parameter
4. **Location Filter**: Non-admin users automatically see data from their assigned location only
5. **Read-Only**: Mobile API is read-only, no create/update/delete operations
6. **Rate Limiting**: Consider implementing rate limiting for production
7. **HTTPS**: Always use HTTPS in production

---

## 🎯 Recommended Implementation Order

1. **Login Screen** → POST `/login`
2. **Dashboard** → GET `/dashboard`, `/dashboard/monthly-revenue`
3. **Vehicle List** → GET `/vehicles`
4. **Vehicle Details** → GET `/vehicles/{id}`
5. **Rental List** → GET `/rentals`, `/rentals/active`
6. **Rental Details** → GET `/rentals/{id}`

---

**Last Updated**: November 4, 2025
**API Version**: 1.0
