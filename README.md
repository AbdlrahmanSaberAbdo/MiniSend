# Overview
A simple application providing an endpoint to send emails, and a page to view the emails (sender, recipient, content, status and attachments).

# Technical Reasoning
The app contains two parts (frontend - backend) with different features
- **Backend**
    - Laravel
    - MySQL
    - Filters (timestamp)
- **Frontend**
    - VueJs
    - Tailwind
    - Get measurements
    - Filtering (day / hour)

# Trade-offs
- Dockrize the frontend & backend
- Create the rest of the CRUD operation in frontend


# Getting start
- Clone the project
- Create `.env` file in the root folder and put the following keys to be able to receive mails (I used mailgun)
  - MAIL_MAILER=mailgun
  - MAIL_HOST=smtp.mailgun.org
  - MAIL_PORT=587
  - MAIL_USERNAME=
  - MAIL_PASSWORD=d
  - MAIL_ENCRYPTION=tls
  - MAIL_FROM_ADDRESS=your-email@gmail.com
  - MAIL_FROM_NAME="Mailer lite"
  - MAILGUN_SECRET=
  - MAILGUN_DOMAIN=
    
- RUN `compoer update`
- RUN `php artisan migrate`
- RUN `yarn && yarn dev` or `npm install && npm run dev`
- RUN `php artisan serve`
- You can run the tests by running `./vendor/bin/phpunit` 
- enjoy :)

# API endpoints
- **Emails**
    - GET: http://localhost:8000/api/v1/emails
    - POST: http://localhost:8000/api/v1/emails
- **Attachments**
    - download(GET): http://localhost:8000/api/v1/attachments/download?attachments_id=...

# Notes
- I used my package [Laragine](https://github.com/yepwoo/laragine) so the application structure follow `HMVC` pattern so to be able to see the `Mail` module you should go to 
this path `core/Mail`

If you woul'd like to know more about **HMVC** pattern check my article on medium, here's the [link](https://abdlrahmansaber.medium.com/how-organize-big-projects-in-laravel-900a3749cfde)
