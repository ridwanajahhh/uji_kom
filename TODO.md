# TODO: Create School Website Display

- [x] Create navbar.blade.php with comprehensive navigation bar for school website
- [x] Create welcome.blade.php with hero section, about section, news/events, gallery, contact, and footer
- [x] Edit layouts.blade.php to include footer yield if needed
- [x] Run Laravel server to test the website display
- [x] Verify styling and functionality (Browser tool disabled, but server is running at http://127.0.0.1:8000)
- [x] Create login view and authentication system
- [x] Create dashboard view for logged-in users with marketplace statistics
- [x] Update navbar to show login/dashboard links based on authentication status
- [x] Create models for Toko, Produk, Kategori, GambarProduk
- [x] Create DashboardController to handle dashboard logic
- [x] Update routes to include dashboard route with auth middleware
- [x] Update AuthController to redirect to dashboard after login
- [x] Create login.blade.php view with form for email and password
- [x] Create AuthController to handle login logic
- [x] Add routes for GET /login (show form) and POST /login (process login) and POST /logout
- [x] Update "Login" button in welcome.blade.php to link to /login route
- [x] Update navbar to show login/logout links based on authentication status
- [x] Run migrations and start Laravel server
