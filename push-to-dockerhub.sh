#!/bin/bash

echo "=========================================="
echo "Pushing Roxnor Docker Image to Docker Hub"
echo "=========================================="
echo ""

# Check if logged in
if ! docker info | grep -q "Username"; then
    echo "Please login to Docker Hub first:"
    echo "Run: docker login"
    echo "Enter your Docker Hub username: elaf24"
    echo "Enter your Docker Hub password"
    echo ""
    read -p "Press Enter after you've logged in..."
fi

echo "Tagging image..."
docker tag roxnor-web:latest elaf24/roxnor:latest

echo ""
echo "Pushing image to Docker Hub..."
docker push elaf24/roxnor:latest

if [ $? -eq 0 ]; then
    echo ""
    echo "✅ Successfully pushed to Docker Hub!"
    echo ""
    echo "Your Docker Hub image URL:"
    echo "https://hub.docker.com/r/elaf24/roxnor"
    echo ""
    echo "Pull command:"
    echo "docker pull elaf24/roxnor:latest"
else
    echo ""
    echo "❌ Failed to push. Please check your Docker Hub credentials."
fi

