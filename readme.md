**Bicycle Theft Application**

This is a web application for managing reported stolen bicycles. It allows users with different roles (admin, police, public) to perform specific actions:

- **Public Users:**
  - Can register new accounts.
  - Can report stolen bicycles (likely through a dedicated view).
  - May have access to a list of reported bicycles (without private details).
- **Police Officers:**
  - Can view a dashboard summarizing reported thefts.
  - Can view detailed reports of stolen bicycles.
  - Can update the investigation status of reported bicycles.
- **Administrators:**
  - Can manage user accounts (likely including creating/deleting users and managing roles).
  - Can view a comprehensive dashboard of reported thefts.
  - May be able to manage enrolled police officers (if applicable).

**Technology Stack:**

The application likely uses a combination of technologies including:

- **PHP**: Server-side scripting language for handling user requests and interacting with the database.
- **MySQL**: Database for storing user information, bicycle details, and reported thefts.
- **HTML/CSS**: Building blocks for the user interface (web pages).
- **JavaScript**: Possibly used for adding interactivity to the application.

**Project Structure:**

The project is organized into folders for better maintainability:

- **config**: Stores configuration details like database connection parameters.
- **controllers**: Contains PHP classes handling user interactions and application logic.
- **db**: Contains database-related resources, potentially including reusable queries and the schema definition.
- **img**: Stores images used in the application.
- **include**: Contains common website header and footer code.
- **models**: Contains PHP classes representing data models (e.g., User, Bicycle) for interacting with database tables.
- **public**: Stores publicly accessible resources like CSS stylesheets and JavaScript files.
- **vendor**: Likely contains third-party libraries used in the project.
- **views**: Contains the different web pages displayed to users based on their roles (admin, police, public).

**Getting Started**

**1. Prerequisites:**

- A web server with PHP support.
- A MySQL database server.

**2. Setup:**

1. Configure the database connection details in `config.php`.
2. Import the database schema from `db/schema.sql` into your MySQL database.
3. Place the project files on your web server's document root.
4. Username and password for admin are `admin` and `admin123` respectively.

**Additional Notes:**

- This README provides a general overview. Specific functionalities and configurations might vary.
- Refer to the individual PHP scripts and controller classes for detailed code documentation.

**Further Development:**

- Implement functionalities specific to your requirements.
- Enhance the user interface for a better user experience.
- Add error handling and security measures.
