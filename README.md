# api-family-business-website
REST API for my family business website project. (o) Parameters are optional

## Offer API

| No.	| Purpose | URL | Method | Format	| Params | Impl |
| --- | --- | --- | --- | --- | --- | --- |
1|Gets item object |/offer/category/item/item.php|GET|JSON|categoryId, itemId| yes
2|Gets array of existant categories|/offer/category/categories.php|GET|JSON| - | yes
3|Gets array of items in specified category|/offer/category/items/items.php|GET|JSON|categoryId| yes

## Gallery API

| No.	| Purpose | URL | Method | Format	| Params | Impl |
| --- | --- | --- | --- | --- | --- | --- |
1|Gets array of album objects|/album/albums.php|GET|JSON|startId, endId (o)| no
2|Gets array of photos objects|/album/photo/photos.php|GET|JSON|albumId, startId, endId (o)| no
3|Generate thumbnails if they don't exist (or force)|/album/photo/generateThumbnails.php|POST|JSON|force| no

