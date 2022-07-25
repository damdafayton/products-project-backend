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

- GET `/api/products/` => retrieves all the products
- GET `/api/products/{productId}` => retrieves product with the given `productId`
- POST `/api/products` => creates a product
- POST `/api/products:massDelete` => deletes more than 1 product
- GET `/api/products?fields` => retrieves the list of categories
- GET `/api/products?fields={fieldName}` => retrievese special attributes of the given `fieldName`

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
