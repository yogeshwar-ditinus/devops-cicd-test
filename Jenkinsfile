pipeline {
    agent any

    environment {
        DOCKER_IMAGE = "mycompany/${env.JOB_NAME.toLowerCase()}:${env.BUILD_NUMBER}"

        DEPLOY_SERVER = "ubuntu@<your-server-ip>"
    }

    stages {

        stage('Checkout Code') {
    steps {
        git branch: 'main', credentialsId: 'github-creds', url: 'https://github.com/yogeshwar-ditinus/devops-cicd-test.git'
    }
}
    
        stage('Install Dependencies') {
            steps {
                sh '''
                    composer install --no-interaction --prefer-dist --optimize-autoloader
                    php artisan config:cache
                '''
            }
        }

        stage('Run Tests') {
            steps {
                sh 'php artisan test || true'
            }
        }

        stage('Build Docker Image') {
            steps {
                sh '''
                    echo "Building Docker image..."
                    docker build -t ${DOCKER_IMAGE} .
                '''
            }
        }

        stage('Push to DockerHub') {
            steps {
                withCredentials([usernamePassword(credentialsId: 'dockerhub-creds', usernameVariable: 'DOCKER_USER', passwordVariable: 'DOCKER_PASS')]) {
                    sh '''
                        echo $DOCKER_PASS | docker login -u $DOCKER_USER --password-stdin
                        docker push ${DOCKER_IMAGE}
                        docker logout
                    '''
                }
            }
        }

        stage('Deploy to Server') {
            steps {
                sshagent(credentials: ['ssh-server-key']) {
                    sh '''
                        ssh -o StrictHostKeyChecking=no ${DEPLOY_SERVER} "
                            docker pull ${DOCKER_IMAGE} &&
                            docker stop laravel_app || true &&
                            docker rm laravel_app || true &&
                            docker run -d --name laravel_app -p 80:80 ${DOCKER_IMAGE}
                        "
                    '''
                }
            }
        }
    }

    post {
        success {
            echo "✅ Laravel Deployment successful!"
        }
        failure {
            echo "❌ Build or deployment failed!"
        }
    }
}
