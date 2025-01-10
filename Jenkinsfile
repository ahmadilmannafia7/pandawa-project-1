pipeline {
    agent any

    environment {
        DOCKER_IMAGE = 'pandawa' // Ganti dengan nama image Docker yang sesuai
        DOCKER_CONTAINER = 'pandawa-app' // Ganti dengan nama container yang sesuai
    }

    stages {
        stage('Checkout') {
            steps {
                script {
                    // Meng-clone repository dari Git
                    git url: 'https://github.com/ahmadilmannafia7/pandawa-project-1' // Ganti dengan URL repository Anda
                }
            }
        }

        stage('Build') {
            steps {
                script {
                    // Menjalankan build Docker
                    bat 'docker build -t ${DOCKER_IMAGE} .' // Gunakan perintah 'bat' untuk Windows
                }
            }
        }

        stage('Run Docker') {
            steps {
                script {
                    // Menjalankan container Docker
                    bat 'docker run -d --name ${DOCKER_CONTAINER} ${DOCKER_IMAGE}' // Gunakan perintah 'bat' untuk Windows
                }
            }
        }

        stage('Test') {
            steps {
                script {
                    // Contoh menjalankan tes atau perintah lainnya
                    bat 'docker ps' // Gunakan perintah 'bat' untuk Windows
                }
            }
        }

        stage('Cleanup') {
            steps {
                script {
                    // Membersihkan container Docker
                    bat 'docker rm -f ${DOCKER_CONTAINER}' // Gunakan perintah 'bat' untuk Windows
                }
            }
        }
    }

    post {
        always {
            // Tahap pembersihan jika dibutuhkan
            echo 'Pipeline selesai!'
        }
    }
}
