# PRODUCT LISTING BACKEND

## Built With

- PHP7, MySQL

## How to Run

- Clone the backend repo to your php server
- Run your server
- Hit `localhost/{WWW_THIS_APP}/seeds/categories.php` on your browser to create category tables
- Hit `localhost/{WWW_THIS_APP}/seeds/products.php` to seed your tables with dummy data
- Set up development front-end from this repo https://github.com/damdafayton/products-project-frontend

## End-points

All the data that is served in the front-end is served from the back-end, hence tha application has single source of truth.

- GET `/api/products` => retrieves all the products
- GET `/api/products/{productId}` => retrieves product with the given `productId`
- GET `/api/products?fields` => retrieves the list of categories
- GET `/api/products?fields={fieldName}` => retrievese special attributes of the given `fieldName`

- POST `/api/products` => creates a product
- POST `/api/products:massDelete` => deletes more than 1 product

## Class Structure

- Database
  - Product
    - Dvd
    - Furniture
    - Book
  - Seeding
    
- BaseController
  - ProductController

It is very easy to create a new category class.
1) Special field traits are imported depending on the features of the product such as: size, weight, length etc...
2) Common methods are imported from another trait.
3) It's required to define the name of special fields and their data-types in an array to feed mysql.
Here is an example.
```
<?php
class Dvd extends Product
{
  use Size;
  use ChildMethods;
  private $privateFields = ['size'];
  private $privateFieldDataTypes = 'i';
}
```

## Authors

👤 **damdafayton**

- [Github](https://github.com/damdafayton)
- [LinkedIn](https://linkedin.com/in/damdafayton)

## 🤝 Contributing

Contributions, issues, and feature requests are welcome!

Feel free to check the [issues page](../../issues/).

## Show your support

Give a ⭐️ if you like this project!

## 📝 License

This project is [MIT](./MIT.md) licensed.
