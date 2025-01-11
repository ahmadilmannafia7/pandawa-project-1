pipeline {
    agent any

    environment {
        DOCKER_TAG = 'latest'
    }

    stages {
        stage('SCM') {
            steps {
                script {
                    git credentialsId: 'pandawa87-project', 
                        url: 'https://github.com/ahmadilmannafia7/pandawa-project-1',
                        branch: 'main'
                }
            }
        }

        stage('Set Version') {
            steps {
                script {
                    def commitHash = bat(script: 'git rev-parse --short HEAD', returnStdout: true).trim()
                    env.DOCKER_TAG = commitHash
                }
            }
        }

        stage('Install Dependencies') {
            steps {
                script {
                    def gdCheck = bat(script: 'php -m | findstr gd', returnStatus: true)
                    if (gdCheck != 0) {
                        error "PHP GD extension is not enabled. Enable it in php.ini."
                    }
                    bat 'composer install --no-dev --optimize-autoloader'
                }
            }
        }

        stage('Docker Build') {
            steps {
                script {
                    bat "docker build -t ahmadilmannafia/pandawa:${env.DOCKER_TAG} ."
                }
            }
        }
    }

    post {
        always {
            script {
                node {
                    echo 'Cleaning up workspace...'
                    cleanWs()
                }
            }
        }

        success {
            script {
                httpRequest(
                    url: 'https://telkomuniversityofficial.webhook.office.com/webhookb2/32a7e491-58ba-4d00-80ce-9235050979f7@90affe0f-c2a3-4108-bb98-6ceb4e94ef15/IncomingWebhook/bdb80034b3e74d18a9619cbb8c962451/5eb143ec-c5e8-4183-aed2-5634c1e19a7a/V28Xvl57hwbOWgyWgtQtopiqhV5tR1VenMvqUxvy5hlWs1',
                    httpMode: 'POST',
                    contentType: 'APPLICATION_JSON',
                    requestBody: '''{
                        "@type": "MessageCard",
                        "@context": "http://schema.org/extensions",
                        "summary": "Proses Build Selesai",
                        "themeColor": "0076D7",
                        "title": "🎉 Proses build selesai!",
                        "text": "Docker image berhasil dibuat dengan tag: pandawa:${env.DOCKER_TAG}. 🔧 Lihat detail build di Jenkins untuk informasi lebih lanjut."
                    }'''
                )
            }
        }

        failure {
            script {
                httpRequest(
                    url: 'https://telkomuniversityofficial.webhook.office.com/webhookb2/32a7e491-58ba-4d00-80ce-9235050979f7@90affe0f-c2a3-4108-bb98-6ceb4e94ef15/IncomingWebhook/bdb80034b3e74d18a9619cbb8c962451/5eb143ec-c5e8-4183-aed2-5634c1e19a7a/V28Xvl57hwbOWgyWgtQtopiqhV5tR1VenMvqUxvy5hlWs1',
                    httpMode: 'POST',
                    contentType: 'APPLICATION_JSON',
                    requestBody: '''{
                        "@type": "MessageCard",
                        "@context": "http://schema.org/extensions",
                        "summary": "Build Gagal",
                        "themeColor": "FF0000",
                        "title": "❌ Build gagal",
                        "text": "Silakan cek detail error di Jenkins untuk penyebab kegagalan. ⚠"
                    }'''
                )
            }
        }
    }
}
