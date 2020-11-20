## Шаблонный проект основанный на Yii 2 для REST API

### 1) Форк
1. Сделать форк(кнопка **Fork**, вторая по счету рядом с заголовком проекта)
1. Переименовать проект(Settings &#8594; General &#8594; Project Name)
1. Сменить URL(Settings &#8594; General &#8594; Advanced &#8594; Change path)
1. Забрать проект с репозитория

### 2) Установка
1. Выполнить ```composer install``` в корневой папке проекта(**Внимание!** Требуется доступ к GitHub.com)
1. В папке *modules* создать папку с названием проекта и скопировать содержимое папки *foo* в\
созданную папку, затем удалить папку *foo*
1. Перейти в папку *web/vue-source/frontend*  и выполнить следующие команды\
```npm install```\
```npm run build```
1. Удалить папку *foo* в папке *web/vue-source*
1. Создать VUE CLI проект **с поддержкой TypeScript(!!! JavaScript НЕ Используем !!!)** в папке *vue-source*. Пример\
использования TypeScript в связке с VUE CLI есть в папке *frontend*. Имя проекта должно совпадать
с именем созданного модуля
1.  В корне папки созданного VUE CLI проекта создать файл ```vue.config.js``` со следующим содержимым(Вместо\
**имя_проекта** вставить имя проекта)
```javascript
module.exports = {
    devServer: {
        proxy: 'http://localhost:85/'
    },
    // assets
    publicPath: process.env.NODE_ENV === 'production' ? '../vue-source/имя_проекта/dist/' : '/',
    // index
    indexPath: process.env.NODE_ENV === 'production' ? '../../../../modules/имя_проекта/views/default/index.php' : 'index.html',
};
```
## ВНИМАНИЕ!
**Необходимо добавлять сгенерированные с помощью VUE CLI файлы *index.php* в ```.gitignore```!**\
**Например: *modules/имя_проекта/views/default/index.php***

## Ссылки
1. Composer для Windows: [Composer-Setup.exe](https://getcomposer.org/Composer-Setup.exe) 
1. NodeJS: [nodejs.org](https://nodejs.org/en/download/) 
1. PHP для Windows: [windows.php.net](https://windows.php.net/download/) 
1. Apache для Windows: [Apache Lounge](https://www.apachelounge.com/download/) 
1. Open Server: [ospanel.io](https://ospanel.io/download/) 




