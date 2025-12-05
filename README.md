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
├── my-adoptions.php           # Adoption history
├── my-requests.php            # Adoption requests
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
│   └── AdoptionController.php # Adoption actions
│
├── views/
│   ├── layouts/
│   │   ├── header.php         # Header layout
│   │   └── footer.php         # Footer layout
│   ├── auth/
│   │   ├── login-view.php     # Login view
│   │   └── signup-view.php    # Signup view
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
   - Place the project in your web server directory (e.g., `htdocs`, `www`)
   - Ensure PHP 7.4+ and MySQL are installed
   - Enable mod_rewrite in Apache (for .htaccess)

4. **Set permissions**
   ```bash
   chmod 755 uploads/pets/
   ```

5. **Access the application**
   - Open browser and navigate to: `http://localhost/pet-adoption-system`

##  User Types

1. **Adopter** - Can browse pets and request adoptions
2. **Owner** - Can add pets and manage adoption requests
3. **Shelter** - Same as Owner, for organizations

##  Features

- ✅ User registration and authentication
- ✅ Browse available pets
- ✅ Add/edit/delete pet listings (Owner/Shelter)
- ✅ Adoption request system
- ✅ Approve/reject adoption requests
- ✅ Adoption history tracking
- ✅ Pet image uploads
- ✅ Featured pets section
- ✅ Responsive design with Bootstrap 5

##  Security Features

- Password hashing using PHP `password_hash()`
- SQL injection prevention with PDO prepared statements
- XSS protection with input sanitization
- Session management
- File upload validation
- Protected directories with .htaccess

##  Notes

- Default timezone is set to 'Asia/Dhaka' (can be changed in `config/config.php`)
- Maximum file upload size: 5MB (configurable)
- Supported image formats: JPEG, PNG, JPG
- Pet images are stored in `uploads/pets/` directory

##  Troubleshooting

1. **Database connection error**: Check credentials in `config/config.php`
2. **Image upload fails**: Ensure `uploads/pets/` directory has write permissions
3. **Session issues**: Check PHP session configuration
4. **404 errors**: Ensure mod_rewrite is enabled in Apache

##  License

This project is open source and available for educational purposes.

---

**Developed with ❤️ for pet adoption**

