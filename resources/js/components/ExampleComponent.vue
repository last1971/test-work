<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">Example Component</div>
                    <div class="card-body btn">
                        {{ result }}
                    </div>
                    <div class="card-body">
                        <div class="btn btn-primary" @click="sendPost">POST /news/update</div>
                        Получение новостей с сайта meduza.io. Параметров запроса нет.
                    </div>
                    <div class="card-body">
                        GET /news/list?day=YYYY-MM-DD[&document_type=DOCUMENT_TYPE]
                        Запрос новостей за день из базы данных.
                        <div class="form-inline">
                            <label class="form-control" >
                                news/list?
                            </label>
                            <input v-model="list" class="form-control"/>
                            <div class="btn btn-primary" @click="sendGet('news/list?' + list)">Проверить</div>
                        </div>
                    </div>
                    <div class="card-body">
                        GET /news/image/new-id
                        Запрос на картинку новости.
                        <div class="form-inline">
                            <label class="form-control" >
                                Пример 1: news/image/
                            </label>
                            <input v-model="e1" class="form-control col-8"/>
                            <div class="btn btn-primary" @click="sendGet('news/image/' + e1)">Проверить</div>
                        </div>
                        <div class="form-inline">
                            <label class="form-control" >
                                Пример 2: news/image/
                            </label>
                            <input v-model="e2" class="form-control col-8"/>
                            <div class="btn btn-primary" @click="sendGet('news/image/' + e2)">Проверить</div>
                        </div>
                        <div class="form-inline">
                            <a href="news/image/feature/2019/03/25/tramp-ne-vstupal-v-sgovor-s-putinym" target="_blank">
                                Пример 3
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                result: 'Тут будет результат последнего запроса',
                list: 'day=today',
                e1: 'news/2019/03/25/chetvero-storonnikov-navalnogo-iz-tatarstana-podali-v-sud-na-vkontakte-sotsset-vydala-ih-personalnye-dannye-tsentru-e',
                e2: 'news/2019/03/25/chetvero',
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            sendPost() {
                this.result = 'Выполняется запрос'
                axios.post('news/update')
                    .then(response => { this.result = response.data })
                    .catch(error => { this.result = error.response.data })
            },
            sendGet(url) {
                this.result = 'Выполняется запрос'
                axios.get(url)
                    .then(response => { this.result = response.data })
                    .catch(error => { this.result = error.response.data })
            }
        }
    }
</script>
