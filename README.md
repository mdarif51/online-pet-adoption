# Pet Adoption System

A comprehensive web-based pet adoption system built with PHP and MySQL that allows users to adopt pets, manage pet listings, and handle adoption requests.

##  Technologies Used

- **PHP** - Server-side scripting
- **MySQL** - Database management
- **HTML** - Structure
- **CSS** - Styling
- **Bootstrap 5** - Responsive UI framework
- **SQL** - Database queries

##  Project Structure

```
pet-adoption-system/
│
├── index.php                  # Home page
├── login.php                  # Login page
├── signup.php                 # Registration page
├── logout.php                 # Logout script
├── browse-pets.php            # Browse all available pets
├── pet-details.php            # Single pet details view
├── my-pets.php                # Owner's pet list
├── add-pet.php                # Add new pet form
├── edit-pet.php               # Edit pet form
├── my-adoptions.php           # Adoption history (Adopter only)
├── my-requests.php            # Adoption requests
├── profile.php                # User profile page
├── delete-pet.php             # Delete pet (Owner/Shelter)
├── create_admin.php           # Admin creation script
│
├── config/
│   └── config.php             # Database connection config
│
├── core/
│   ├── Database.php           # Database connection class
│   ├── Session.php            # Session handler
│   ├── Auth.php               # Login / logout logic
│   └── Validator.php          # Input validation methods
│
├── models/
│   ├── User.php               # User class
│   ├── Pet.php                # Pet class
│   ├── Adoption.php           # Adoption history class
│   └── AdoptionRequest.php    # Adoption request class
│
├── controllers/
│   ├── AuthController.php     # Auth actions
│   ├── PetController.php      # Pet actions
│   ├── AdoptionController.php # Adoption actions
│   ├── UserController.php     # User profile actions
│   └── AdminController.php    # Admin actions
│
├── admin/
│   ├── dashboard.php          # Admin dashboard
│   ├── featured-pets.php      # Featured pets management
│   └── all-pets.php           # All pets management
│
├── views/
│   ├── layouts/
│   │   ├── header.php         # Header layout
│   │   └── footer.php         # Footer layout
│   ├── auth/
│   │   ├── login-view.php     # Login view
│   │   └── signup-view.php    # Signup view
│   ├── user/
│   │   └── profile-view.php   # User profile view
│   ├── admin/
│   │   ├── dashboard-view.php      # Admin dashboard
│   │   ├── pending-pets-view.php  # Pending pets approval
│   │   ├── featured-pets-view.php # Featured pets management
│   │   ├── all-pets-view.php      # All pets management
│   │   └── adopted-pets-view.php  # Adopted pets list
│   ├── pets/
│   │   ├── browse-view.php    # Browse pets UI
│   │   ├── my-pets-view.php   # Owner pet dashboard
│   │   ├── add-pet-view.php   # Add pet UI
│   │   └── edit-pet-view.php  # Edit pet UI
│   └── adoption/
│       ├── my-requests-view.php  # Requests list
│       └── my-adoptions-view.php # Adoption history
│
├── uploads/
│   └── pets/                  # Pet images folder
│
├── assets/
│   ├── css/
│   │   └── styles.css         # Main stylesheet
│   └── js/
│       └── main.js            # Custom scripts
│
├── database.sql               # Database schema
├── .htaccess                  # Apache configuration
└── README.md                  # Project documentation
```

##  Database Setup

1. Create a MySQL database named `pet_adoption`
2. Import the database schema from `database.sql`:
   ```sql
   mysql -u root -p pet_adoption < database.sql
   ```
   Or use phpMyAdmin to import the `database.sql` file

3. Update database credentials in `config/config.php`:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   define('DB_NAME', 'pet_adoption');
   ```

##  Database Schema

### Tables

1. **users** - Stores user information (Adopter, Owner, Shelter)
2. **pets** - Stores pet listings with details
3. **adoption** - Stores completed adoption history
4. **adopt_request** - Stores pending/approved/rejected adoption requests

##  Installation & Setup

1. **Clone or download the project**
   ```bash
   git clone <repository-url>
   cd pet-adoption-system
   ```

2. **Configure the database**
   - Update `config/config.php` with your database credentials
   - Import `database.sql` into your MySQL database

3. **Set up web server**
   - Place the project in your web server directory (e.g. `htdocs`)
   - Ensure PHP 7.4+ and MySQL are installed
   - Enable mod_rewrite in Apache (for .htaccess)

4. **Set permissions**
   ```bash
   chmod 755 uploads/pets/
   ```
5. **Access the application**
   - Open browser and navigate to: `http://localhost/pet-adoption-system`

##  User Types

এই সিস্টেমে চার ধরনের user রয়েছে:

1. **Adopter** - যারা pet adopt করতে চায়
   - Available pets browse করতে পারে
   - Adoption request করতে পারে
   - তাদের adoption history দেখতে পারে

2. **Owner** - Pet Owner (যাদের pet আছে এবং adoption করতে চায়)
   - তাদের pet add/edit/delete করতে পারে
   - Adoption requests দেখতে এবং approve/reject করতে পারে

3. **Shelter** - Pet Shelter/Organization (Owner এর মতোই কাজ করতে পারে)
   - Owner এর মতো সব সুবিধা পায়
   - Organization হিসেবে pet adoption manage করতে পারে

4. **Admin** - Site Administrator
   - Pet approval/rejection করতে পারে
   - Featured pets manage করতে পারে
   - সব pets দেখতে এবং delete করতে পারে
   - Adopted pets list দেখতে পারে
   - **Important:** Admin signup form এ নেই, manually `create_admin.php` দিয়ে create করতে হয়

**Note:** 
- "Owner" মানে **Pet Owner** (যাদের pet আছে), Site Owner নয়
- "Admin" মানে **Site Administrator**, যারা full site manage করে

##  Features

-  User registration and authentication
-  User profile management (view/edit profile, change password)
-  Browse available pets
-  Add/edit/delete pet listings (Owner/Shelter)
-  Adoption request system
-  Approve/reject adoption requests
-  Adoption history tracking
-  Pet image uploads
-  Featured pets section (managed by Admin)
-  Admin panel for site management
-  Admin can manage featured pets
-  Admin can view/delete all pets
-  Responsive design with Bootstrap 5





