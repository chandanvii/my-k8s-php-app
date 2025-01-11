pipeline {
    agent any

    environment {
        // Define environment variables
        DOCKER_IMAGE = 'php-app'              // Name of your Docker image (can be customized)
        DOCKER_TAG = 'latest'                 // Tag for your Docker image
        REGISTRY = 'docker.io'                // Docker registry (Docker Hub)
        REPO = 'chandanviii'                  // Your Docker Hub username (replace with 'chandanviii')
        K8S_CONFIG = '/home/jenkins/.kube/config'  // Path to the kubeconfig file on the Jenkins server (adjust if necessary)
    }

    stages {
        stage('Checkout Code') {
            steps {
                // Clone your GitHub repository
                git 'https://github.com/chandanvii/my-k8s-php-app.git'  // Replace with your GitHub repository URL
            }
        }

        stage('Build Docker Image') {
            steps {
                script {
                    // Build the Docker image
                    docker.build("${REGISTRY}/${REPO}/${DOCKER_IMAGE}:${DOCKER_TAG}")
                }
            }
        }

        stage('Push Docker Image') {
            steps {
                script {
                    // Push the Docker image to Docker Hub (authenticate using Jenkins credentials)
                    docker.withRegistry('https://docker.io', 'docker-hub-credentials') {
                        docker.image("${REGISTRY}/${REPO}/${DOCKER_IMAGE}:${DOCKER_TAG}").push()
                    }
                }
            }
        }

        stage('Deploy to Kubernetes') {
            steps {
                script {
                    // Deploy to Kubernetes using the kubeconfig from Jenkins credentials
                    withKubeConfig([credentialsId: 'your-kube-credentials-id']) {
                        sh 'kubectl apply -f k8s/deployment.yml'
                        sh 'kubectl apply -f k8s/service.yml'
                        sh 'kubectl apply -f k8s/ingress.yml'
                    }
                }
            }
        }
    }

    post {
        success {
            echo 'Build and deployment successful!'
        }
        failure {
            echo 'Build or deployment failed!'
        }
    }
}
