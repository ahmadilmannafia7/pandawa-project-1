pipeline {
    agent any
    tools {
        jdk 'JDK 21'
        maven 'maven3'
    }

    environment {
        GIT_COMMIT_SHORT = "${sh(script: 'git rev-parse --short HEAD', returnStdout: true).trim()}"
        TEAMS_WEBHOOK_URL = 'https://telkomuniversityofficial.webhook.office.com/webhookb2/32a7e491-58ba-4d00-80ce-9235050979f7@90affe0f-c2a3-4108-bb98-6ceb4e94ef15/IncomingWebhook/0e24ad599f5c4fbd8525cf35fe91cb92/5eb143ec-c5e8-4183-aed2-5634c1e19a7a/V2zYbXK6ZdAjbU5FGzUN6IDSaLh5TWHGdC2Gjlfk7EOnc1'
    }

    stages {
        stage('Checkout') {
            steps {
                // Checkout repository dari GitHub dengan menggunakan kredensial Anda
                git credentialsId: 'github-credentials-id', branch: 'main', url: 'https://github.com/ahmadilmannafia7/pandawa-project-1.git'
            }
        }

        stage('Create Dockerfile') {
            steps {
                writeFile file: 'Dockerfile', text: '''
FROM php:8.2-fpm
# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libicu-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd &&
    docker-php-ext-configure intl &&
    docker-php-ext-install intl

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer &&
    chown -R $user:$user /home/$user

# Set working directory
WORKDIR /var/www

# Add permissions for www-data
COPY . /var/www/
RUN chown -R www-data:www-data /var/www
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache
'''
            }
        }

        stage('Build Docker Image') {
            steps {
                // Build Docker image dengan tag berdasarkan commit
                sh "docker build -t ahmadilmannafia/pandawa-app:${env.GIT_COMMIT_SHORT} ."
            }
        }

        stage('Push Docker Image') {
            steps {
                // Login ke Docker Hub menggunakan kredensial
                withCredentials([usernamePassword(credentialsId: 'dockerhub-credentials-id', usernameVariable: 'DOCKER_USER', passwordVariable: 'DOCKER_PASS')]) {
                    sh """
                    echo '${DOCKER_PASS}' | docker login -u ${DOCKER_USER} --password-stdin
                    docker push ahmadilmannafia/pandawa-app:${env.GIT_COMMIT_SHORT}
                    """
                }
            }
        }

        stage('Deploy Laravel Application') {
            steps {
                // Deploy aplikasi Laravel menggunakan Docker Compose
                sshagent(['ssh-credentials-id']) {
                    sh """
                    ssh your-deployment-server << EOF
                    # Pull image terbaru
                    docker-compose pull

                    # Shutdown container yang sedang berjalan
                    docker-compose down

                    # Jalankan ulang container dengan force recreate
                    docker-compose up -d --force-recreate
                    EOF
                    """
                }
            }
        }
    }

    post {
        success {
            // Kirim notifikasi ke Teams jika build berhasil
            script {
                def message = "Build and Deployment Successful! Commit: ${env.GIT_COMMIT_SHORT}"
                sh """
                curl -H "Content-Type: application/json" -d '{
                    "text": "${message}"
                }' ${env.TEAMS_WEBHOOK_URL}
                """
            }
        }

        failure {
            // Kirim notifikasi ke Teams jika build gagal
            script {
                def message = "Build and Deployment Failed! Commit: ${env.GIT_COMMIT_SHORT}"
                sh """
                curl -H "Content-Type: application/json" -d '{
                    "text": "${message}"
                }' ${env.TEAMS_WEBHOOK_URL}
                """
            }
        }
    }
}
