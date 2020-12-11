# Version Control for out database

### Flyway
Flyway is an open-source database migration tool use to write migration in SQL.
More info in the official [documentantion](https://flywaydb.org/documentation/)

#### Setup & Run
* Download the flyway tool on your local machine from the [community page](https://flywaydb.org/download/community)
* After you have the command-line tool on your machine, create a copy of the `flyway.conf.example` file into `flyway.conf`
* Update the `flyway.conf` file with your database information.
* Under `sql` folder we will have our migration file written in sql. The first migration file `V0001__Create_Base` contains the starting point of our current database schema
* Note that the sql files should be prefixed with version like `V0001__` (double underscore), so the next one will be `V0002__` etc.
* Use `flyway info` command to check your migration status. Run the command from the `database` folder where your `flyway.conf` file is located
* To run the migration (execute the sql) rum `flyway migrate`

Notes:
 * At first run of migrate flyway will create a table of history,`flyway_schmea_history`, under the `public` schema.
  * First run of `flyway migrate` on a database that is not empty will not run the `V0001__Create_Base.sql` it will create a makr a baseline in migration table.
