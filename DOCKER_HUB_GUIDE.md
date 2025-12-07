# Docker Hub Image Upload Guide

## What is a Containerized Docker Image?

A containerized Docker image is a packaged version of your application that includes:
- Your application code
- PHP runtime (8.1)
- Apache web server
- All dependencies
- Configuration files

This image can be run on any machine with Docker installed, without needing to install PHP, Apache, or any dependencies.

## Steps to Upload to Docker Hub

### Step 1: Create Docker Hub Account (if you don't have one)

1. Go to https://hub.docker.com/
2. Click "Sign Up" (it's free)
3. Verify your email address

### Step 2: Login to Docker Hub from Terminal

```bash
docker login
```

Enter your Docker Hub username and password when prompted.

### Step 3: Tag Your Image

Replace `YOUR_DOCKERHUB_USERNAME` with your actual Docker Hub username:

```bash
# Tag the existing image with your Docker Hub username
docker tag roxnor-web:latest YOUR_DOCKERHUB_USERNAME/roxnor:latest

# Example: if your username is "johndoe"
# docker tag roxnor-web:latest johndoe/roxnor:latest
```

### Step 4: Push to Docker Hub

```bash
# Push the image to Docker Hub
docker push YOUR_DOCKERHUB_USERNAME/roxnor:latest

# Example:
# docker push johndoe/roxnor:latest
```

### Step 5: Verify on Docker Hub

1. Go to https://hub.docker.com/
2. Navigate to your repositories
3. You should see `roxnor` repository
4. Copy the image URL: `YOUR_DOCKERHUB_USERNAME/roxnor:latest`

## Image URL Format

Your Docker Hub image URL will be:
```
https://hub.docker.com/r/YOUR_DOCKERHUB_USERNAME/roxnor
```

Or the pull command:
```
docker pull YOUR_DOCKERHUB_USERNAME/roxnor:latest
```

## How Others Can Use Your Image

Once uploaded, anyone can run your application with:

```bash
# Pull your image
docker pull YOUR_DOCKERHUB_USERNAME/roxnor:latest

# Run it (they'll also need docker-compose.yml for the database)
docker-compose up -d
```

## Alternative: Using docker-compose.yml

You can also update your `docker-compose.yml` to use the Docker Hub image instead of building locally:

```yaml
services:
  web:
    image: YOUR_DOCKERHUB_USERNAME/roxnor:latest  # Instead of build: .
    container_name: roxnor_web
    # ... rest of the configuration
```

## Important Notes

1. **Make sure your image is public** (or share access if private)
2. **Include docker-compose.yml** so they can run the full stack (web + database)
3. **Document the image URL** in your README.md
4. **Test the image** before submitting:
   ```bash
   docker pull YOUR_DOCKERHUB_USERNAME/roxnor:latest
   docker run -p 8080:80 YOUR_DOCKERHUB_USERNAME/roxnor:latest
   ```

