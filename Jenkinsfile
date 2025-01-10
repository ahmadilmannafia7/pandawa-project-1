pipeline {
    agent any

    environment {
        IMAGE_TAG = ''
    }

    stages {
        stage('Source Code Checkout') {
            steps {
                script {
                    try {
                        checkout scm: [
                            $class: 'GitSCM', 
                            branches: [[name: '*/main']],
                            userRemoteConfigs: [[url: 'https://github.com/farul1/Kasir_CafeVNT', credentialsId: 'cafevnt-github']]
                        ]
                    } catch (Exception e) {
                        error "Source code checkout failed: ${e.message}"
                    }
                }
            }
        }

        stage('Retrieve Commit Hash') {
            steps {
                script {
                    try {
                        def commitHash = bat(script: 'git rev-parse --short HEAD', returnStdout: true).trim()
                        IMAGE_TAG = commitHash
                    } catch (Exception e) {
                        error "Unable to retrieve commit hash: ${e.message}"
                    }
                }
            }
        }

        stage('Dependency Installation') {
            steps {
                script {
                    try {
                        def isGdEnabled = bat(script: 'php -m | findstr gd', returnStatus: true)
                        if (isGdEnabled != 0) {
                            error "PHP GD extension is not enabled. Please check php.ini."
                        }
                        bat 'composer install --no-dev --optimize-autoloader'
                    } catch (Exception e) {
                        error "Dependency installation failed: ${e.message}"
                    }
                }
            }
        }

        stage('Build Docker Image') {
            when {
                expression { currentBuild.result == null }
            }
            steps {
                script {
                    try {
                        bat "docker build -t farul672/vnt_kasir:${IMAGE_TAG} ."
                    } catch (Exception e) {
                        error "Docker image build failed: ${e.message}"
                    }
                }
            }
        }
    }

    post {
        always {
            echo 'Cleaning workspace after build...'
            cleanWs()
        }

        success {
            echo 'Pipeline completed successfully!'
            script {
                def successMessage = ":rocket: **Build Successful!** Docker image tagged: ${IMAGE_TAG}. :tada: The cafe cashier system is ready to launch! Check the Jenkins logs for more info, and let's get brewing! :coffee:"
                sh """
                curl -H "Content-Type: application/json" -d '{
                    "text": "${successMessage}"
                }' ${env.TEAMS_WEBHOOK_URL}
                """
            }
        }

        failure {
            echo 'Pipeline failed, check logs for more details.'
            script {
                def failureMessage = ':x: **Build Failed!** Something went wrong during the build. Check the logs to fix the issue. We’ve got this! :muscle:'
                sh """
                curl -H "Content-Type: application/json" -d '{
                    "text": "${failureMessage}"
                }' ${env.TEAMS_WEBHOOK_URL}
                """
            }
        }
    }
}
