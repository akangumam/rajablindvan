# Flutter API Configuration

Copy file-file ini ke Flutter project kamu.

---

## 1. lib/config/api_constants.dart

```dart
class ApiConstants {
  // Base URLs
  static const String developmentBaseUrl = 'http://127.0.0.1:8000/api/v1';
  static const String productionBaseUrl = 'https://rajafleet.khaerulumam.id/api/v1';

  // Environment
  static const bool isDevelopment = true; // Set false untuk production

  // Active Base URL
  static String get baseUrl => isDevelopment ? developmentBaseUrl : productionBaseUrl;

  // Auth Endpoints
  static const String login = '/login';
  static const String logout = '/logout';
  static const String me = '/me';

  // Dashboard Endpoints
  static const String dashboard = '/dashboard';
  static const String monthlyRevenue = '/dashboard/monthly-revenue';

  // Vehicle Endpoints
  static const String vehicles = '/vehicles';
  static String vehicleDetail(int id) => '/vehicles/$id';
  static String vehicleRentals(int id) => '/vehicles/$id/rentals';
  static String vehicleMaintenances(int id) => '/vehicles/$id/maintenances';

  // Rental Endpoints
  static const String rentals = '/rentals';
  static const String activeRentals = '/rentals/active';
  static String rentalDetail(int id) => '/rentals/$id';

  // Headers
  static Map<String, String> get headers => {
    'Accept': 'application/json',
    'Content-Type': 'application/json',
  };

  static Map<String, String> headersWithToken(String token) => {
    'Accept': 'application/json',
    'Content-Type': 'application/json',
    'Authorization': 'Bearer $token',
  };

  // Timeouts
  static const Duration connectTimeout = Duration(seconds: 30);
  static const Duration receiveTimeout = Duration(seconds: 30);

  // Pagination
  static const int defaultPageSize = 20;
}
```

---

## 2. lib/services/api_service.dart

```dart
import 'package:dio/dio.dart';
import 'package:flutter_secure_storage/flutter_secure_storage.dart';
import '../config/api_constants.dart';

class ApiService {
  static final ApiService _instance = ApiService._internal();
  factory ApiService() => _instance;

  late Dio _dio;
  final _storage = const FlutterSecureStorage();

  ApiService._internal() {
    _dio = Dio(
      BaseOptions(
        baseUrl: ApiConstants.baseUrl,
        connectTimeout: ApiConstants.connectTimeout,
        receiveTimeout: ApiConstants.receiveTimeout,
        headers: ApiConstants.headers,
      ),
    );

    // Add interceptors
    _dio.interceptors.add(
      InterceptorsWrapper(
        onRequest: (options, handler) async {
          // Add token to request
          final token = await getToken();
          if (token != null) {
            options.headers['Authorization'] = 'Bearer $token';
          }
          return handler.next(options);
        },
        onError: (error, handler) async {
          // Handle 401 Unauthorized
          if (error.response?.statusCode == 401) {
            await clearToken();
            // Navigate to login page
          }
          return handler.next(error);
        },
      ),
    );
  }

  Dio get dio => _dio;

  // Token Management
  Future<void> saveToken(String token) async {
    await _storage.write(key: 'auth_token', value: token);
  }

  Future<String?> getToken() async {
    return await _storage.read(key: 'auth_token');
  }

  Future<void> clearToken() async {
    await _storage.delete(key: 'auth_token');
  }

  Future<bool> hasToken() async {
    final token = await getToken();
    return token != null && token.isNotEmpty;
  }

  // Generic Request Methods
  Future<Response> get(String path, {Map<String, dynamic>? queryParameters}) async {
    try {
      return await _dio.get(path, queryParameters: queryParameters);
    } catch (e) {
      rethrow;
    }
  }

  Future<Response> post(String path, {dynamic data}) async {
    try {
      return await _dio.post(path, data: data);
    } catch (e) {
      rethrow;
    }
  }

  // Auth API Calls
  Future<Map<String, dynamic>> login(String email, String password) async {
    try {
      final response = await post(
        ApiConstants.login,
        data: {'email': email, 'password': password},
      );

      if (response.data['success'] == true) {
        final token = response.data['data']['token'];
        await saveToken(token);
        return response.data;
      }
      throw Exception(response.data['message'] ?? 'Login failed');
    } on DioException catch (e) {
      if (e.response?.data != null) {
        throw Exception(e.response!.data['message'] ?? 'Login failed');
      }
      throw Exception('Network error: ${e.message}');
    }
  }

  Future<void> logout() async {
    try {
      await post(ApiConstants.logout);
      await clearToken();
    } catch (e) {
      await clearToken(); // Clear token even if request fails
    }
  }

  Future<Map<String, dynamic>> getMe() async {
    try {
      final response = await get(ApiConstants.me);
      return response.data;
    } catch (e) {
      rethrow;
    }
  }

  // Dashboard API Calls
  Future<Map<String, dynamic>> getDashboard() async {
    final response = await get(ApiConstants.dashboard);
    return response.data;
  }

  Future<Map<String, dynamic>> getMonthlyRevenue() async {
    final response = await get(ApiConstants.monthlyRevenue);
    return response.data;
  }

  // Vehicle API Calls
  Future<Map<String, dynamic>> getVehicles({
    String? search,
    String? status,
    int? locationId,
    int page = 1,
  }) async {
    final queryParams = <String, dynamic>{};
    if (search != null) queryParams['search'] = search;
    if (status != null) queryParams['status'] = status;
    if (locationId != null) queryParams['location_id'] = locationId;
    queryParams['page'] = page;

    final response = await get(ApiConstants.vehicles, queryParameters: queryParams);
    return response.data;
  }

  Future<Map<String, dynamic>> getVehicleDetail(int id) async {
    final response = await get(ApiConstants.vehicleDetail(id));
    return response.data;
  }

  Future<Map<String, dynamic>> getVehicleRentals(int id, {int page = 1}) async {
    final response = await get(
      ApiConstants.vehicleRentals(id),
      queryParameters: {'page': page},
    );
    return response.data;
  }

  Future<Map<String, dynamic>> getVehicleMaintenances(int id, {int page = 1}) async {
    final response = await get(
      ApiConstants.vehicleMaintenances(id),
      queryParameters: {'page': page},
    );
    return response.data;
  }

  // Rental API Calls
  Future<Map<String, dynamic>> getRentals({
    String? status,
    int? customerId,
    int? vehicleId,
    int page = 1,
  }) async {
    final queryParams = <String, dynamic>{};
    if (status != null) queryParams['status'] = status;
    if (customerId != null) queryParams['customer_id'] = customerId;
    if (vehicleId != null) queryParams['vehicle_id'] = vehicleId;
    queryParams['page'] = page;

    final response = await get(ApiConstants.rentals, queryParameters: queryParams);
    return response.data;
  }

  Future<Map<String, dynamic>> getActiveRentals({int page = 1}) async {
    final response = await get(
      ApiConstants.activeRentals,
      queryParameters: {'page': page},
    );
    return response.data;
  }

  Future<Map<String, dynamic>> getRentalDetail(int id) async {
    final response = await get(ApiConstants.rentalDetail(id));
    return response.data;
  }
}
```

---

## 3. lib/models/user.dart

```dart
class User {
  final int id;
  final String name;
  final String email;
  final String role;
  final int? locationId;
  final String? locationName;

  User({
    required this.id,
    required this.name,
    required this.email,
    required this.role,
    this.locationId,
    this.locationName,
  });

  factory User.fromJson(Map<String, dynamic> json) {
    return User(
      id: json['id'],
      name: json['name'],
      email: json['email'],
      role: json['role'],
      locationId: json['location_id'],
      locationName: json['location']?['name'],
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'name': name,
      'email': email,
      'role': role,
      'location_id': locationId,
    };
  }

  bool get isAdmin => role == 'super_admin';
}
```

---

## 4. lib/models/vehicle.dart

```dart
class Vehicle {
  final int id;
  final String brand;
  final String model;
  final String? licensePlate;
  final int year;
  final String? color;
  final String? vin;
  final String status;
  final int? locationId;
  final String? locationName;
  final double? dailyRate;
  final double? weeklyRate;
  final double? monthlyRate;

  Vehicle({
    required this.id,
    required this.brand,
    required this.model,
    this.licensePlate,
    required this.year,
    this.color,
    this.vin,
    required this.status,
    this.locationId,
    this.locationName,
    this.dailyRate,
    this.weeklyRate,
    this.monthlyRate,
  });

  factory Vehicle.fromJson(Map<String, dynamic> json) {
    return Vehicle(
      id: json['id'],
      brand: json['brand'],
      model: json['model'],
      licensePlate: json['license_plate'],
      year: json['year'],
      color: json['color'],
      vin: json['vin'],
      status: json['status'],
      locationId: json['location_id'],
      locationName: json['location']?['name'],
      dailyRate: json['daily_rate']?.toDouble(),
      weeklyRate: json['weekly_rate']?.toDouble(),
      monthlyRate: json['monthly_rate']?.toDouble(),
    );
  }

  String get displayName => '$brand $model';

  String get statusDisplay {
    switch (status) {
      case 'available':
        return 'Tersedia';
      case 'rented':
        return 'Disewa';
      case 'maintenance':
        return 'Maintenance';
      default:
        return status;
    }
  }
}
```

---

## 5. lib/models/dashboard_stats.dart

```dart
class DashboardStats {
  final int totalVehicles;
  final int availableVehicles;
  final int rentedVehicles;
  final int maintenanceVehicles;
  final int activeRentals;
  final double monthlyRevenue;
  final double monthlyExpenses;
  final double netIncome;
  final int upcomingMaintenance;
  final int overdueRentals;
  final Map<String, int>? vehiclesByLocation;
  final List<Activity> recentActivities;

  DashboardStats({
    required this.totalVehicles,
    required this.availableVehicles,
    required this.rentedVehicles,
    required this.maintenanceVehicles,
    required this.activeRentals,
    required this.monthlyRevenue,
    required this.monthlyExpenses,
    required this.netIncome,
    required this.upcomingMaintenance,
    required this.overdueRentals,
    this.vehiclesByLocation,
    required this.recentActivities,
  });

  factory DashboardStats.fromJson(Map<String, dynamic> json) {
    final data = json['data'];
    return DashboardStats(
      totalVehicles: data['vehicles']['total'],
      availableVehicles: data['vehicles']['available'],
      rentedVehicles: data['vehicles']['rented'],
      maintenanceVehicles: data['vehicles']['maintenance'],
      activeRentals: data['rentals']['active'],
      monthlyRevenue: data['financial']['monthly_revenue'].toDouble(),
      monthlyExpenses: data['financial']['monthly_expenses'].toDouble(),
      netIncome: data['financial']['net_income'].toDouble(),
      upcomingMaintenance: data['alerts']['upcoming_maintenance'],
      overdueRentals: data['alerts']['overdue_rentals'],
      vehiclesByLocation: data['vehicles_by_location'] != null
          ? Map<String, int>.from(data['vehicles_by_location'])
          : null,
      recentActivities: (data['recent_activities'] as List)
          .map((a) => Activity.fromJson(a))
          .toList(),
    );
  }
}

class Activity {
  final String type;
  final String description;
  final DateTime date;

  Activity({
    required this.type,
    required this.description,
    required this.date,
  });

  factory Activity.fromJson(Map<String, dynamic> json) {
    return Activity(
      type: json['type'],
      description: json['description'],
      date: DateTime.parse(json['date']),
    );
  }
}
```

---

## 6. Usage Example - Login Screen

```dart
import 'package:flutter/material.dart';
import '../services/api_service.dart';

class LoginScreen extends StatefulWidget {
  @override
  _LoginScreenState createState() => _LoginScreenState();
}

class _LoginScreenState extends State<LoginScreen> {
  final _formKey = GlobalKey<FormState>();
  final _emailController = TextEditingController(text: 'admin@rajablindvan.com');
  final _passwordController = TextEditingController(text: 'password');
  bool _isLoading = false;

  Future<void> _login() async {
    if (!_formKey.currentState!.validate()) return;

    setState(() => _isLoading = true);

    try {
      final response = await ApiService().login(
        _emailController.text,
        _passwordController.text,
      );

      // Navigate to home screen
      Navigator.pushReplacementNamed(context, '/home');

    } catch (e) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text(e.toString())),
      );
    } finally {
      setState(() => _isLoading = false);
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Padding(
        padding: EdgeInsets.all(16),
        child: Form(
          key: _formKey,
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              TextFormField(
                controller: _emailController,
                decoration: InputDecoration(labelText: 'Email'),
                validator: (v) => v?.isEmpty ?? true ? 'Required' : null,
              ),
              SizedBox(height: 16),
              TextFormField(
                controller: _passwordController,
                decoration: InputDecoration(labelText: 'Password'),
                obscureText: true,
                validator: (v) => v?.isEmpty ?? true ? 'Required' : null,
              ),
              SizedBox(height: 24),
              ElevatedButton(
                onPressed: _isLoading ? null : _login,
                child: _isLoading
                    ? CircularProgressIndicator()
                    : Text('Login'),
              ),
            ],
          ),
        ),
      ),
    );
  }
}
```

---

## Testing di Flutter

### 1. Development (Local Laravel)

```dart
// di lib/config/api_constants.dart
static const bool isDevelopment = true;
```

-   Jalankan Laravel: `php artisan serve`
-   Base URL: `http://127.0.0.1:8000/api/v1`

### 2. Production

```dart
// di lib/config/api_constants.dart
static const bool isDevelopment = false;
```

-   Base URL: `https://rajafleet.khaerulumam.id/api/v1`
-   Pastikan API sudah di-deploy ke production

---

## Credentials untuk Testing

```
Email: admin@rajablindvan.com
Password: password

atau cek di database production
```
