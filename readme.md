# Admin panel for online store with CMS functionality, build on Laravel 5.7

You can test it [here](http://lutory.net/laravel-admin/public/), using the following credentials to access the Admin panel:

**Username**: admin@gmail.com
**Password**: AdminP@assword

---- Notes:

- The system is still in development, so bugs are possible
- It will include the front part also, once the Admin is complete

# Functionality:

## Products

-  List of all the products with a filter to narrow down the results based on product Category, Status and Product name
- Create, Update and Delete a product
- Products can belong to multiple categories. 
- Products can have multiple tags that are shared with the posts
- Products can have comments, which can be deleted through the corresponding product and to change their status
- Products have gallery - multiple images can be added to a product through File Manager

- Categories can be added and edited. A category can be ordered and can have a subcategory, its own image and body, not only title

- Product filters with multiple fields are connected to a category and can be filled while creating or editing a product (in development)

## Posts

- The posts also have full CRUD functionality and filtering
- Every post has a category, tags, gallery and comments

## Pages

- Pages can be created, edited and deleted. 
- The main content of the page is a tinyMce textarea with the ability to add images

## Tags

- Tags are shared between posts and products. A single tag can be connected to both
- Tags can be created, edited, deleted and searched
- Every tag show its corresponding posts and products

## Users

- The website uses the Laravel native Auth functionality
- Every user has a default role of a Client and can't access the Admin panel
- Through the Admin panel the users list can be accessed and a different role can be added, including the Administrator role
- Users can be added, edited and deleted
- Role of Author will be added and that person will be able to create posts but not access the products functionality
