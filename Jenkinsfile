pipeline {
    agent any
    tools {
        jdk 'JDK 21'
    }

    environment {
        IMAGE_TAG = ''
        TEAMS_WEBHOOK = 'https://telkomuniversityofficial.webhook.office.com/webhookb2/32a7e491-58ba-4d00-80ce-9235050979f7@90affe0f-c2a3-4108-bb98-6ceb4e94ef15/IncomingWebhook/0e24ad599f5c4fbd8525cf35fe91cb92/5eb143ec-c5e8-4183-aed2-5634c1e19a7a/V2zYbXK6ZdAjbU5FGzUN6IDSaLh5TWHGdC2Gjlfk7EOnc1'
    }

    stages {
        stage('Source Code Retrieval') {
            steps {
                script {
                    try {
                        git credentialsId: 'pandawa-github', url: 'https://github.com/ahmadilmannafia7/pandawa-project-1.git'
                    } catch (Exception e) {
                        error "Failed to retrieve source code: ${e.message}"
                    }
                }
            }
        }

        stage('Generate Version') {
            steps {
                script {
                    try {
                        def commitHash = bat(script: 'git rev-parse --short HEAD', returnStdout: true).trim()
                        IMAGE_TAG = commitHash
                    } catch (Exception e) {
                        error "Failed to generate commit hash: ${e.message}"
                    }
                }
            }
        }

        stage('Dependency Setup') {
            steps {
                script {
                    try {
                        def isGdInstalled = bat(script: 'php -m | findstr gd', returnStatus: true)
                        if (isGdInstalled != 0) {
                            error "PHP GD extension is missing. Enable it in php.ini."
                        }
                        bat 'composer install --no-dev --optimize-autoloader'
                    } catch (Exception e) {
                        error "Dependency installation failed: ${e.message}"
                    }
                }
            }
        }

        stage('Docker Image Creation') {
            when {
                expression { currentBuild.result == null }
            }
            steps {
                script {
                    try {
                        bat "docker build -t ahmadilmannafia/pandawa-app:${IMAGE_TAG} ."
                    } catch (Exception e) {
                        error "Docker image creation failed: ${e.message}"
                    }
                }
            }
        }
    }

    post {
        always {
            echo 'Cleaning workspace after execution...'
            cleanWs()
        }

        success {
            echo 'Pipeline completed successfully!'
            script {
                def successMessage = "🚀 **Build Successful!** Docker image built with tag: ${IMAGE_TAG}. 🎉 The Pandawa system is ready to roll out. Check Jenkins logs for more info and enjoy your coffee! ☕"
                sh """
                curl -H "Content-Type: application/json" -d '{
                    "text": "${successMessage}"
                }' ${env.TEAMS_WEBHOOK}
                """
            }
        }

        failure {
            echo 'Pipeline execution failed. Check logs for details.'
            script {
                def failureMessage = '❌ **Build Failed!** Something went wrong! Check the Jenkins logs to find out more. We’ll sort it out! 💪'
                sh """
                curl -H "Content-Type: application/json" -d '{
                    "text": "${failureMessage}"
                }' ${env.TEAMS_WEBHOOK}
                """
            }
        }
    }
}
