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
1|Gets array of album objects|/gallery/getAlbums.php|GET|JSON|start, length (o)| yes
2|Gets specific album object along with photo urls|/gallery/getAlbum.php|GET|JSON|albumId| yes
3|Generate thumbnails if they don't exist (or force)|/album/photo/generateThumbnails.php|POST|JSON|force| no

## Mailing API

| No.	| Purpose | URL | Method | Format	| Params | Impl |
| --- | --- | --- | --- | --- | --- | --- |
1|Send an email|/mailing/postCustomerMail.php|POST|JSON|name, email, content (request body)| yes

## Reviews API

| No.	| Purpose | URL | Method | Format	| Params | Impl |
| --- | --- | --- | --- | --- | --- | --- |
1|Gets array of review objects|/reviews/getReviews.php|GET|JSON|start, length (o)| yes

## Session API

| No.	| Purpose | URL | Method | Format	| Params | Impl |
| --- | --- | --- | --- | --- | --- | --- |
1|Create session (Log in)|/session/create/create.php|POST|JSON|login, password (hashed)| yes
2|Delete session (Log out)|/session/delete/delete.php|DELETE|JSON|sessionToken| yes
