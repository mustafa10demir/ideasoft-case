<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Kurulum

Docker ile laravel projesini ayağa kaldırmak için;

```shell
composer install 
```

```shell
docker-compose up --build
```
- Veritabanı Migrate ve Seeding işlemleri, build sürecinde otomatik olarak gerçekleştirilir.


## API List

Postman api documentation : [https://documenter.getpostman.com/view/8787859/2sA3kaBJwH ](https://documenter.getpostman.com/view/8787859/2sA3kaBJwH)

Postman Json File: [Download](https://raw.githubusercontent.com/mustafa10demir/ideasoft-case/main/IdeaSoftCase.postman_collection.json) 


## İndirim Tanımlama

İndirimler **offers**  tablosu ve **offer_discounts** tablosundan dinamik olarak gelir.

Örneğin, belirtilen kategoriye ait ürünlerden toplam 1000 TL ve üzeri alışveriş yapan müşterilere %10 indirim sağlar.

### offers tablosu:
| Alan Adı   | Değer                     |
|------------|---------------------------|
| name       | 2_CATEGORY_1000_LIMIT_10_SALE |
| total_price| 1000                      |
| category_id| 2                         |

### offer_discounts tablosu:
| Alan Adı         | Değer |
|------------------|-------|
| percent_discount | 10    |
| is_total         | 1     |


## DB Designer

<img src="https://raw.githubusercontent.com/mustafa10demir/ideasoft-case/main/DbDesign.png" width="100%">
