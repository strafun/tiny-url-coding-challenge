This is the codding challenge for the TinyURL.
## Let's go!

Let's divide our work for 5 parts:
- Gather requirements
- Create architecture
- Data Storage
- Develop
- Possible improvements and conclusion


### Gather requirements

Some of the requirements I took from the task description and some have added by myself to make system work faster and make more sense for the real world project.

- Entity `product`. Each product should have name, description, price, category. 
- We should handle 100 million product records. 
- We should provide CRUD operations for the Product. Deletion should be `safe` - without real deleting from the database.  
- We should provide product `listing` with possibility filter by name, price, category ASC and DESC. Show 50 products per page with pagination. 
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
- We should use `Pull CDN` for the fronend static Vue.js SPA.
- We will use `Load Balancer` to receive low latency and be able to scale and protect system against fail. 
- Load balancer will allow to use `active-active fail-over` for the servers
- We will use Master-Slave DB replication that will separate write from read operations. We will allow manage average DB load with amount of slaves. 
- We will use DB caching with Redis. 
- We will use `Cache-aside` caching strategy. It will give us strong consistency.
- We should add `monitoring` to our infrastructure. 

As the result we can create a diagram of our application:

![architecture](https://github.com/strafun/tiny-url-codding-challange/blob/main/architecture.png?raw=true)


### Data Storage

We will use 3 types of the storage:

1. Mysql as RDBMS
2. Redis as In memory NooSql cache solution
3. Client cookies

We need to provide storage only for two instances `Products` and `Categories`. But we will use some denormalisation and cache technique:

#### Mysql as RDBMS

- Create table Products with PK, name, price and category. Create indexes. 
- Let's assume that category is required and not null - it gives us better performance. 
- As `description` is the field with the largest memory size, but we need it only on the `product view/edit page` we can move it to the separate table. And use in queries on the page of the product only. 
- We will have separate table for the top_products. As we are expecting that top products will be less than 0.001% there is no necessary to add them to the products table. 
- Categories - we will have `categories` table separately but will not use relation for the products table. As we need to sort by category name, we will denormalize the product table and include a category name as text there and add index on it. 

#### Redis as In memory NooSql cache solution
 
What we are planning to cache: 

- Categories - 10 000 records
- First 5 pages of all types of sorts. We have 6 different one. Statistically, most clients reach only first 5 pages. As we have 50 product on the page we will have 50 * 5 * 6 = 1500 products in cache. 
- We should include our top products to the cached version pages.

#### Client cookies

We will store last 10 viewed products in the client cookies. In such case we completely avoid any server loads related to this business process in our app. We still can gather visited history for some other our business needs. But even in case when we will have such information on our servers we better to leave this part to the client side. 

## Develop

- CRUD will represent 3 pages list, edit/create page and product view. 
- Search will represent one page. 
- There is 2 main approaches for the sorting and pagination `Cursor pagination` and `Deferred joins`. Let's compare performance. We will use Cursor pagination in the search page as it should be faster. And Deferred joins in CRUD list page. 
