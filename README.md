# Blooms Co. Website

A website for selling graduation-related products using HTML, CSS, PHP, JavaScript, and MySQL.

## Features

### User Features

- User Registration and Login
- Account Management with Edit Functionality
- Product Browsing with Filtering
- Shopping Cart Functionality
- Order Placement and View Order Details

### Admin Features

- User Management
- Product Management (CRUD operations)
- Category and Brand Management
- Order Management
- Sales Analytics

## Tech Stack

- Frontend:
  - HTML5
  - CSS3
  - JavaScript
  - Responsive Design
- Backend:
  - PHP 8.4.4
  - MySQL
- Additional Features:
  - Session Management
  - File Upload Handling
  - Secure Password Hashing
  - Input Validation

## Database Structure

The project uses a normalized database schema with the following key tables:

- `user_table`: Stores user information and authentication details
- `admin_table`: Stores admin credentials
- `categories`: Manages product categories
- `brands`: Manages product brands
- `products`: Stores product information and details
- `cart_details`: Manages shopping cart items
- `orders`: Stores order information
- `order_details`: Stores individual order items
- `product_sales`: Tracks product sales statistics

## Setup Instructions

1. Install XAMPP or any other PHP development environment
2. Clone the repository to your htdocs folder
3. Import the SQL schema from `sql.txt` to your MySQL database
4. Configure the database connection in `config/helper.php`
5. Start your Apache and MySQL services
6. Access the application through your web browser

## Security Features

- Password hashing using bcrypt
- SQL injection prevention
- XSS protection
- Session management
- Input validation
- File upload security

## Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Support

For support, please create an issue in the GitHub repository or contact the project maintainers.

## Acknowledgments

- This project uses the [Montserrat](https://fonts.google.com/specimen/Montserrat) font.
