pipeline {
    agent none
    stages {
        stage('Docker up') {
            agent any
            steps {
                label 'Subir containers de banco de dados'
                sh 'curl -L "https://github.com/docker/compose/releases/download/1.26.1/docker-compose-$(uname -s)-$(uname -m)" -o docker-compose'
                sh 'chmod +x docker-compose'
                sh './docker-compose -f docker-compose-tests.yml down --remove-orphans'
                sh './docker-compose -f docker-compose-tests.yml up -d'
                sh 'mkdir -p /tmp/composer'
                sh 'chmod -R 777 /tmp/composer'
            }
        }
        stage('PHP 7.2') {
            agent {
                docker {
                    image 'composer.insis.com.br:8083/inovadora-dev/php-cli:7.2-latest'
                    registryUrl 'https://composer.insis.com.br:8083'
                    registryCredentialsId 'franklin-inovadorahub'
                    args '-v ${PWD}:/home/inovadora/wokspace -u 1000 -v /tmp/composer:/home/inovadora/.composer:rw --network inovadora'
                    alwaysPull true
                }
            }
            steps {
                sh 'php -v'
                sshagent(credentials: ['jenkins-private-key']){
                    sh 'ssh-keyscan -H bitbucket.org >> ~/.ssh/known_hosts'
                    sh 'composer update -vvv'
                }
                sh 'php ./vendor/bin/phinx migrate'
                sh 'php ./vendor/bin/phpunit --configuration $PWD/phpunit.xml $PWD/tests'
            }
        }
        stage('PHP 7.3') {
            agent {
                docker {
                    image 'composer.insis.com.br:8083/inovadora-dev/php-cli:7.3-latest'
                    registryUrl 'https://composer.insis.com.br:8083'
                    registryCredentialsId 'franklin-inovadorahub'
                    args '-v ${PWD}:/home/inovadora/wokspace -u 1000 -v /tmp/composer:/home/inovadora/.composer:rw --network inovadora'
                    alwaysPull true
                }
            }
            steps {
                sh 'php -v'
                sshagent(credentials: ['jenkins-private-key']){
                    sh 'ssh-keyscan -H bitbucket.org >> ~/.ssh/known_hosts'
                    sh 'composer update -vvv'
                }
                sh 'php ./vendor/bin/phinx migrate'
                sh 'php ./vendor/bin/phpunit --configuration $PWD/phpunit.xml $PWD/tests'
            }
        }
        stage('Docker down') {
            agent any
            steps {
                label 'Remover containers de banco de dados'
                sh './docker-compose -f docker-compose-tests.yml down --remove-orphans'
            }
        }
        stage('Sonar') {
            agent {
                docker {
                    image 'composer.insis.com.br:8083/inovadora-dev/php-cli:7.3-latest'
                    registryUrl 'https://composer.insis.com.br:8083'
                    registryCredentialsId 'franklin-inovadorahub'
                    args '-v ${PWD}:/home/inovadora/wokspace -u 1000 -v /tmp/composer:/home/inovadora/.composer:rw --network inovadora'
                    alwaysPull true
                }
            }
            steps {
                sh '~/sonar-scanner/bin/sonar-scanner'
            }
        }

    }
    post {
        always {
            emailext attachLog: true,
                     attachmentsPattern: 'generatedFile.txt',
                     body: "${currentBuild.currentResult}: Job ${env.JOB_NAME} build ${env.BUILD_NUMBER}\n More info at: ${env.BUILD_URL}",
                     recipientProviders: [developers(), requestor()],
                     subject: "Jenkins Build ${currentBuild.currentResult}: Job ${env.JOB_NAME}"
            node(null) {
                deleteDir()
                dir("${workspace}@tmp") {
                    deleteDir()
                }
                dir("${workspace}@script") {
                    deleteDir()
                }
            }
        }
    }
}
