import smtplib
sender_email = "email here" #do not change
rec_email = "email here" #you can change this email to your email to test
password = "password here" #do not change
server = smtplib.SMTP('smtp.gmail.com', 587)
server.starttls()
server.login(sender_email, password)
print("Login success")
with open('/var/www/html/login_demo/last-login.txt') as f:
    strings = ("'", "--", "=", ";", "#", " ")
    for line in f:
        if any(s in line for s in strings):
            print(line)
            message = "Hey, this was sent using python. SQL Injection attempted. '{}' was entered in username or password field.".format(line)
            server.sendmail(sender_email, rec_email, message)
            print("Email has been sent to", rec_email)