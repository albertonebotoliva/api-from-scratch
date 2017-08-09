API test

Author: Alberto Nebot
Review: Deezer

Specs:

Create MiniAPI - RESTful API - JSON-API

1 - Access Resources:

  - Get User by ID: {id} => {id, name, email}
  - Get Song by ID: {id} => {id, name, duration}

2 - Handle Favorites:

  - Return list
  - Add Song
  - Remove Song

Susceptible to upgrades (outputs, attributes, objects). Use MySQL


Proposed Solution:

Micro-framework M*C:

  Controllers: (Specific to the resource)
  
  - BaseController
  - Favorites
  - Songs
  - Users
  
  Libs:
  
  - API
  - Auth
  - Database
  - Request
  - Response
  
  Models:
  
  - AuthModel
  - BaseModel
  - ResourcesModel


RESTful specs:

Please NOTE that the base uri is set to /deezer/ either in .htaccess (RewriteBase) and index.php (BASE_URI).Update to your project path.

All the call need HEADER Authorization = 123

Available Resources:
  GET    /deezer/users/1 - Return user 1
  
  GET    /deezer/songs/1 - Return song 1
  
  GET    /deezer/favorites/1 - Return favorites for user 1
  
  POST   /deezer/favorites/ - Add song to favorite.
  
    - Please send in the body: i.e. {"song_id": "3"}
    - User comes from token
  
  DELETE /deezer/favorites/ - Delete song from favorite.
  
    - Please send in the body: i.e. {"song_id": "3"}
    - User comes from token


To add a new resource:

  Insert in the table resources a new row
  
  - name. Name of the resource.
  - method. Available method
  - action. Action dispatched by this method
  - format. Accepted format
  - query_field. In case that you want to filter by any field.

  Create a controller with the name of the resource. Or just add the required action to the Basecontroller.
