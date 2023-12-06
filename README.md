This is the codding challenge for the TinyURL.
## Let's go!

Let's divide our work for 5 parts:
- Gather requirements
- Create architecture
- Data Storage
- Develop
- Possible improvements and conclusion
- How to run


### Gather requirements

Some of the requirements I took from the task description and some have added by myself to make system work faster and make more sense for the real world project.

- Entity `product`. Each product should have name, description, price, category. 
- We should handle 100 million product records. 
- We should provide CRUD operations for the Product. Deletion should be with moving to archive.  
- We should provide product `listing` with possibility filter by name, price, category ASC and DESC. Show 30 products per page with pagination. 
- We should be able to mark products as a `top` and show them at the top of the list. There will be around 0.01% of the top products.
- Entity `product category`. Each category should have a unique name. And let's assume that we have 10 000 categories. 
- We should be able to add a category.
- We should remember last 10 products viewed by user.
- The mostly often write operation within our system will be the `price` update. And we're expecting that we need update the price of 5% of the catalog within one wek. it means that we will have 100 000 000 * 0.05 / 7 / 24 / 60 / 60 ~ 9 write operations per second. 
- We are expecting traffic around half million users per day and each user make around 20 requests on our site. It means that we will have 500 000 * 20 / 24 / 60 / 60 ~ 232 read operations per second. 
- We should use Laravel as backend, Vue.js as frontend and Mysql as RDBMS. Other part of the system can be on purpose. 
- Make system be able to scale. 
- Ensure that all actions on the site execute in less than 500ms.

### Create architecture

- We will use `Strong Consistency`.
- We should use `Horizontal and Vertical Scaling`. We have quite high load and from one side our servers should be powerful enough to handle it and from other side we need to have a low latency.
- We will use `Load Balancer` to receive low latency and be able to scale and protect system against fail. 
- Load balancer will allow to use `active-active fail-over` for the servers
- We will use Master-Slave DB replication that will separate write from read operations. We will allow manage average DB load with amount of slaves. 
- We will use DB caching with Redis. 
- We will use `Cache-aside` caching strategy. It will give us strong consistency.
- Add a queue for slow operations like read and write on a big tables with a heavy index. 
- We should add `monitoring` to our infrastructure. 

As the result we can create a diagram of our application:

![architecture](https://raw.githubusercontent.com/strafun/tiny-url-coding-challenge/master/arch.png)


### Data Storage

We will use 3 types of the storage:

1. Mysql as RDBMS
2. Redis as In memory NooSql cache solution
3. Client cookies

We need to provide storage only for two instances `Products` and `Categories`. But we will use some denormalisation and cache technique:

#### Mysql as RDBMS

- Create table Products with PK, name, price and category. Create indexes for the name, price and category as we need make sorting. 
- Let's assume that category is required and not null - it gives us better performance. 
- `description` is the field with the largest memory size, but we need it only on the `product view/edit page`. We can move it to the separate table. And use in queries on target pages only. 
- We will have a separate table for the `top products`. As we are expecting that top products will be less than 0.001% there is no necessary to add them to the products table. 
- For categories, we will use a presorted related table technique. When the related table always sorted by the name. Then in the main table we can sort by foreign key. And we will receive sort by related table name without any join. Wierd solution, but I sow it few time on production and it works. Alternatively we can denormalize the main table, but it makes it quite bigger and the index is even heavier.

#### Redis as In memory NooSql cache solution
 
What we are planning to cache: 

- Categories - 10 000 records.
- Top products.

#### Client cookies

We will store last 10 viewed products in client cookies. In such case we completely avoid any server loads related to this business process in our app. We still can gather visited history for some other our business needs. But even in case when we will have such information in DB, it is better to leave this part on the client side. 

## Develop

- CRUD will represent 4 pages list, edit/create page and product view. 
- Search will represent one page. With top products and last visited blocks.
- There is 2 main approaches for the sorting and pagination on high volumes `Cursor pagination` and `Deferred joins`. Let's compare performance. We will use Cursor pagination in the search page as it should be faster. And Deferred joins in CRUD list page. 

## Possible improvements and conclusion

### Improvements

- Add unit tests for services and queues.
- Use `Elasticsearch` layers between server and DB. In such case we can avoid to have strange alphabetic logic for the categories and remove top products from the cache. 
- Use `Pull CDN` for the fronend static Vue.js SPA.
- Move the queue to Redis cache.

### Conclusion
With this task I am trying to deliver my knowledge in the architecture, DB design, and Laravel. Not only resolve the task. 

If you have any question - let me know. 

### How to run
1. Get this repo
2. install composer, nodeJs, npm, PHP, MySQL.
3. Run `composer install`.
4. Run `cp .env.example .env`
5. Run `php artisan key:generate`
6. Run `npm i`.
7. Run  `php artisan migrate`.
8. Run `php artisan db:seed` it will create categories and will add them to cache.
9. Now we need to generate 100 mil of products. You can use my seeder `php artisan db:seed --class=ProductSeeder` in generates 10 mil per one run. I have used parallel runs. Or use your own technique to generate dummy data.
10. Run queue worker `php artisan queue:work.`
11. Run laravel server `php artisan serve`.
12. Build Vite for production `npm run build` or use dev mode `npm run dev`. 
13. Go to the http://localhost:8000 and enjoy :) 
