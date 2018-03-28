# Satoshitango

Simple RESTful API to Read, Create, Delete and update. 

## Getting Started

To use the API you need to have a valid Token. You can use four simple calls to use this API:

#### Read

Read call return all data in the items database, for example the way to use is:

```
http://localhost/get/token/{token_value}
```

A example of return is: 

```json
{
    "items":[
        {
            "id":1,
            "item_name":"The Itcher",
            "item_description":"Scratch any itch",
            "item_size":"XL",
            "item_cost":"27"
        },
        {
            "id":2,
            "item_name":"The Blinger",
            "item_description":"Diamonds",
            "item_size":"L",
            "item_cost":"343"
        },
        {
            "id":3,
            "item_name":"Glitz and Gold",
            "item_description":"Gold handle and fancy emeralds make this shine",
            "item_size":"XL,L,M,S",
            "item_cost":"4343"
        }
    ]
}
```


Also read call accepts to send and ID to read data from a specific item in the db.

```
http://localhost/get/id/{item_id}/token/{token_value}
``` 
A example for id 2 is:

```json
[
  {
    "id":2,
    "item_name":"The Blinger",
    "item_description":"Diamonds",
    "item_size":"L",
    "item_cost":"343"
  }
]
```

#### Pagination

The default item return number is 10 items per call, if you have more than 10 items in your db the response will look like:

```json
{
    "items":[
        {
            "id":1,
            "item_name":"The Itcher",
            "item_description":"Scratch any itch",
            "item_size":"XL",
            "item_cost":"27"
        },
        {
            "id":2,
            "item_name":"The Blinger",
            "item_description":"Diamonds",
            "item_size":"L",
            "item_cost":"343"
        },
        {
            "id":3,
            "item_name":"Glitz and Gold",
            "item_description":"Gold handle and fancy emeralds make this shine",
            "item_size":"XL,L,M,S",
            "item_cost":"4343"
        }
    ],
    "pagination":
    {
        "next":3,
        "prev":1
    }
}
```
In this response the current page is 2, and the api add de pagination values, you can use the pagination to navigate between pages:

```
http://localhost/get/page/{page_number}/token/{token_value}
```
 
### Create

with this call you can able to insert new items in the db, in this call **all the field are required**.

The way to use it is: 

```
http://localhost/create/name/{item_name}/desc/{item_description}/size/{item_size}/cost/{item_cost}/token/{token_value}
```

If you pull all the data correctly the response will look like this: 

```json
{
  "code": 200, 
  "msg": "Item created"
}
```

### Delete

With this call you can delete items from the db, the way to use is simple:

```
http://localhost/delete/id/{item_id}/token/{token_value}
``` 
The response will look like: 

```json
 {
   "code": 200, 
   "msg": "Item deleted"
 }
```

### Update

In this call you can able to update que current data of the items (name, description, size and cost), to use it you need to send the ID (requiered) and at lease 1 field to edit if you only send the id the API return error code. 

The way to use it is:

```
http://localhost/update/id/{item_id}/name/{item_name}/desc/{item_description}/size/{item_size}/cost/{item_cost}/token/{token_value}
``` 

The response will look like: 

```json
 {
   "code": 200, 
   "msg": "Item Updated"
 }
```

## Built With

* [ThingEngineer](https://github.com/ThingEngineer/PHP-MySQLi-Database-Class) - PHP MySQLi Database Class

## Author

* **Jose Flores** - *Initial work*

## License

This project is licensed under the GNU Public License - see the [License](http://opensource.org/licenses/gpl-3.0.html) site.