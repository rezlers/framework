# framework
Basic entities and description

 Basic objects:
    App (Dependency Injection Container)
    DB (For working with DB)
    Router (For creating a routing table and storing current response's params)
 The main architectural components:
    Model
    View
    Controller
    Middleware
    Router
    Container (App)
    
App is a box with objects. To "place" a object in a box = come up with an alias for class and specify the namespace in a special configuration list

DB is an object of the Model class, with which you can easily make "dry" queries to any of the databases described in a special configuration file at any point in the application.

Router is an object of the Router class that consists the routing table and params of current response.

Request Life Cycle
1) The request goes to the server, then using htaccess request is redirected to index.php
2) Using the autoload.php script, all main entities are configured
3) Next, the request passes the global middleware (if specified by the user)
4) Next, the request is "caught" by the controller method 'handle' and if everything was fine at the middleware level, then it goes to the router, otherwise the 'abort' method throws an error
5) Next, the route either gives callback to the request or sends it to the controller
6) In conclusion, depending on the request, something happens :)
        
Router
    1) Contains an associative array 'routes', which contains the request method, url, controller
    2) Adding a new path will look like:
        Router-> method (url, controller or callback); -- returns the controller
    3) Also, the parameters of the current request will be stored in the object Router
App
    DI-Container. It will perform the tasks of service storing and will also resolve dependencies
Controller
    The main task is to provide some functionality for the application, some of which will then be stored and executed from the "box" App
    The main methods:
        middleware - to bind an intermediary
        view - for working with templates
        abort - for working with errors
        log - for logging
        authentication - for authentication
        authorization - for authorization
Middleware
    Main goals:
        1) Filtering (or validating) requests
        2) Security (e.g. csrf protection)
        3) Implement custom middleware
View
    A set of scripts waiting for certain parameters to generate an html page
Model
    1) Connections to various databases will be described in a special configuration file
    2) Implementation of the ORM system, that is, let us have a table A, then the user creates a class A (or with a different name), which inherits the Model class and indicates the name of the table in a special field
    3) Work with the object will look like:
        UserClass-> connection ('NameOfConnection') -> method (params);
        where method are some simple table queries
    4) Also for "dry" sql queries, the DB object will be used like this:
        DB-> connection ('NameOfConnection') -> statement ();
