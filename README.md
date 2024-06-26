
# Srijuice Website

## Overview

This project is a Responsive E-Commerce website named Srijuice. The website allows users to browse products, manage their accounts, and place orders.




## Preview

*Demo:* https://srijuice.cloudkp.com

<table>
  <tr>
    <td><img src="https://github.com/rekcah-pavi/SriJuice/blob/main/photos/w1.png?raw=true"/></td>
    <td><img src="https://github.com/rekcah-pavi/SriJuice/blob/main/photos/w2.png?raw=true"/></td>
  </tr>
  <tr>
    <td><img src="https://github.com/rekcah-pavi/SriJuice/blob/main/photos/w3.png?raw=true"/></td>
    <td><img src="https://github.com/rekcah-pavi/SriJuice/blob/main/photos/w4.png?raw=true"/></td>
  </tr>
  <tr>
    <td><img src="https://github.com/rekcah-pavi/SriJuice/blob/main/photos/a1.png?raw=true"/></td>
    <td><img src="https://github.com/rekcah-pavi/SriJuice/blob/main/photos/a2.png?raw=true"/></td>
  </tr>
</table>


<table>
  <tr>
    <td><img src="https://github.com/rekcah-pavi/SriJuice/blob/main/photos/s1.png?raw=true"/></td>
    <td><img src="https://github.com/rekcah-pavi/SriJuice/blob/main/photos/s2.png?raw=true"/></td>
  </tr>
  <tr>
    <td><img src="https://github.com/rekcah-pavi/SriJuice/blob/main/photos/s3.png?raw=true"/></td>
    <td><img src="https://github.com/rekcah-pavi/SriJuice/blob/main/photos/s4.png?raw=true"/></td>
  </tr>

</table>



## Setup Instructions

### Prerequisites

- Php
- MySQL Database
- SMTP Server

### Installation

1. **Clone the repository:**
   ```sh
   git clone https://github.com/rekcah-pavi/SriJuice
   cd srijuice
   ```


2. **Configure Database Connection:**
   - Open `SYS/server.php`.
   - Update the following fields with your database details:
     ```php
     $servername = "";
     $username = "";
     $password = "";
     $database = "";
     ```

3. **Configure SMTP:**
   - Open `SYS/mail_handler.php`.
   - Update the following fields with your details:
     ```php
      $smtp_host= "";
      $smtp_port="587";
      $mail_username="";
      $mail_password= "";
     ```

4. **Configure Admin email , password:**
   - Open `SYS/server.php`.
   - Update the following fields with your details:
     ```php
     $admin_email = "";
     $admin_pass = "";
     ```

5. **Run the Application:**
     ```sh
     php -S localhost:8000
     #or use xxamp
     ```



## Technologies Used

- **Frontend:**
  - HTML5, CSS3, 
  - JavaScript, jQuery, Ajax
  - Font Awesome for icons

- **Backend:**
  - PHP for server-side scripting
  - Session for user authentication
  - Cookie for cart management

- **Other Tools:**
  - Google Maps API for embedding location maps

## Key Functionalities

### 1. Home Page
- Displays a welcome message and an introduction to Srijuice.
- Showcases featured juice products with images.

### 2. Product Management
- Admins can add, edit, and delete products.
- Users can add products to their cart
- Products are displayed with their images, names, and prices.

### 3. User Authentication
- Users can sign up and log in.
- Admin and user sessions are managed to restrict access to certain pages.

### 4. Account Management
- Users can update their account details and address information.
- Users can view their past orders.
- Admins can update,delete, and view orders.

### 5. Shopping Cart
- Displays a summary of the cart with total amount calculation.


## License

This project is licensed under the Unlicense License. See the [LICENSE](LICENSE) file for details.
