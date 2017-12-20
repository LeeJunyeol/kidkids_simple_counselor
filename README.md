# 키드키즈 고민상담소

htdocs 디렉토리에 소스코드를 복사합니다.

```git
\$ cd %XAMPP_HOME%/htdocs

\$ git clone https://github.com/LeeJunyeol/kidkids_simple_counselor.git

\$ git checkout -b renewal

```

xampp control panel을 열어 apache 서버를 실행한 후, url에 아래의 주소를 입력합니다.

/kidkids_simple_counselor/home


# URL Map

- ErrorDocument 404     /ksc/public/404.php

- RewriteRule ^home$ public/home.php
- RewriteRule ^write\/?$ public/write.php
- RewriteRule ^update/([0-9]+)$ public/write.php?question_id=$1
- RewriteRule ^question/([0-9]+)$ public/question.php?question_id=$1
- RewriteRule ^admin$ public/admin.php

- RewriteRule ^api/([a-zA-Z]+)\/?$ api/Controllers/$1.php
- RewriteRule ^api/([a-zA-Z]+)/([0-9]+)$ api/Controllers/$1.php?id=$2
- RewriteRule ^api/([a-zA-Z]+)/([0-9]+)/([a-zA-Z]+)\/?$ api/Controllers/$1.php?id=$2&action=$3
- RewriteRule ^api/my/([a-zA-Z]+)/([0-9]+)$ api/Controllers/$1.php?id=$2&my=true