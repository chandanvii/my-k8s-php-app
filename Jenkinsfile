pipeline {
    agent any

    // environment {
    //     DOCKER_COMPOSE_FILE = 'docker-compose.yml'
    //     DOCKER_IMAGE_TAG = 'latest'
    //     DOCKERHUB_CREDENTIALS = 'dockerhub-credentials-id' // Replace with your Jenkins credential ID
    //     DOCKERHUB_USERNAME = 'chandanviii' // Your Docker Hub username
    //     REPO_NAME = 'chandanviii/php-app' // Your Docker Hub repository name
    // }

    stages {
        stage('Checkout Code') {
            steps {
                checkout scm
            }
        }

        stage('Build and Push Docker Images') {
            steps {
                script {
                    sh 'docker-compose down' // Stop existing containers if running
                    sh 'docker-compose build' // Build Docker images
                    
                    // docker.withRegistry('https://registry.hub.docker.com', DOCKERHUB_CREDENTIALS) {
                    //     sh "docker tag php-app:latest ${DOCKERHUB_USERNAME}/${REPO_NAME}:latest"
                    //     sh "docker push ${DOCKERHUB_USERNAME}/${REPO_NAME}:latest"
                    // }
                }
            }
        }

        stage('Deploy Services') {
            steps {
                script {
                    sh 'docker-compose up -d'
                }
            }
        }
        
        stage('Post Deployment Testing') {
            steps {
                script {
                    sh 'curl -I http://localhost:8081' // Test PHP app
                    sh 'curl -I http://localhost:8082' // Test phpMyAdmin
                }
            }
        }
    }

    post {
        success {
            echo 'Pipeline executed successfully!'
        }
        failure {
            echo 'Pipeline failed. Check logs for details.'
        }
    }
}
