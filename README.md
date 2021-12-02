# Meal Planning For Everyone

# Project Description
This is a recipe sharing web application.  Once complete users will be able to add their own recipes for others to browse as well as 
browse other's recipes.  If time permits there will also be a calendar that functions as a meal planner.

# Links
- [Repo](https://github.com/connerar/Project <Meal Planning For Everyone Repo)
- [Live](http://35.175.153.217 <Live View)

# How to Use
The web application is being hosted on an AWS server.  There is currently a home page that allows one to login, add recipes, and view recipes.

The Login system requires users to make a username and password.  The requirements for passwords are listed on the page.  Passwords are hashed and salted for security purposes.

The Add Recipe system allows users to generate a page for their recipe.  Users enter a name, description, prep time, cook time, ingredient list, instructions and an image.  These will then be used to generate a new page for that recipe.

The View Recipe system allows users to view 10 recipes at a time.  If there are less than 10 recipes on the page, it is the final page and no next arrow will appear.  If users to try get to a page that doesn't exist through the URL they will receive a Page Not Found error.  Users can also filter by a single ingredient and creator.  These filters can be used simultaneously.


# Built With
- HTML
- CSS
- PHP
