## How to setup project:
- `docker compose up -d --build`
- `docker exec -it wiseteam_php composer install`
- `docker exec -it wiseteam_php npm i && npm run dev`
- if you want access the container: `docker exec -it wiseteam_php bash`

## Access
- website: localhost:8000
- Login creds: `test@test.com` - `test123`

## Database
- user: `root`
- db: wiseteam
- password: `password`
- port: `5432`