Problems to search
==================
global $arv; in a function, even if it not exists, it will be created on function ??


>> Try to use router, request, .... easily : 
Application::$app->router  ==> App:router | Application::$router

>> put all funciton user authentication in one class in the core

Securities issues  Middlewares : Security
=========================================
Cross-site request forgery (CSRF) validation middleware
To prevent a CSRF attack a framework can choose to add a certain validation to a request. This validation need to happen before the main action is triggered. In this case a middleware can examine the request object. If it deems the request valid, it can pass it along to the next handler. But if the validation fails, the middleware can immediately short-circuit the request, and return a 403 Forbidden response.

>> https://doeken.org/blog/middleware-pattern-in-php#:~:text=Middleware%20in%20PHP%20is%20a,output%2C%20right%20in%20the%20middle.

