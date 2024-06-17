
# Srijuice Website

## Overview

Welcome to the Srijuice project repository! This project is a website for Srijuice, a vibrant oasis of fresh, locally sourced juices. The website allows users to browse products, manage their accounts, and place orders. This README provides an overview of the project structure, setup instructions, and key functionalities.




## Preview

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





## Setup Instructions

### Prerequisites

- Php
- MySQL Database

### Installation

1. **Clone the repository:**
   ```sh
   git clone https://github.com/your-username/Srijuice.git
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

4. **Configure Admin email , password:**
   - Open `SYS/server.php`.
   - Update the following fields with your SMTP server details:
     ```php
     $admin_email = "";
     $admin_pass = "";
     ```

5. **Run the Application:**
     ```sh
     php -S localhost:8000
     ```



## Technologies Used

- **Frontend:**
  - HTML5, CSS3, 
  - JavaScript, jQuery, Ajax
  - Font Awesome for icons

- **Backend:**
  - PHP for server-side scripting
  - Session,Cookie management for user authentication

- **Other Tools:**
  - Google Maps API for embedding location maps
    

## Contribution

To contribute to this project, please fork the repository, create a new branch, and submit a pull request. Ensure your code follows the project's coding standards and includes appropriate documentation.

## License

This project is licensed under the Eclipse Public License. See the [LICENSE](LICENSE) file for details.
