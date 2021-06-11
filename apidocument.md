# Create a new CarMake
**URL** : `/api/car-make/`

**Method** : `POST`

# Get CarMakes
**URL** : `/api/car-make/`

**Method** : `GET`


# Create CarModel
**URL** : `/api/car-model/`

**Method** : `POST`

**Data constraints**

```json
{
    "make_id": "[id of the created car make]"
}
```
# Get CarModel
**URL** : `/api/car-model/`

**Method** : `GET`

**Data constraints**

To filer the result
```json
{
    "make_id": "id of the created car make",
    "model": "model name"
}
```

# Create car
**URL** : `/api/car`

**Method** : `POST`

**Data constraints**

```json
{
    "make_id": "make_id",
    "model_id":  "model_id",
    "id":  "id",
    "year":  "year",
    "variant": "variant"
}
```
# Edit car
**URL** : `/api/car/{id}`

**Method** : `PATCH`

**Data constraints**

provide any of the field needs to get updated
```json
{
    "make_id": "make_id",
    "model_id":  "model_id",
    "year":  "year",
    "variant": "variant"
}
```

# List cars
**URL** : `/api/car`

**Method** : `GET`

**Data constraints**

provide any of the field needs to get filter
```json
{
    "id": "id",
    "make_id": "make_id",
    "model_id":  "model_id",
    "year":  "year",
    "variant": "variant",
    "per_page": "per_page",
    "page": "page number",
    "order_by": "order by"
}
```
# Delete car
**URL** : `/api/car/{id}`

**Method** : `DELETE`


