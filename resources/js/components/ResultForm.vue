<template>
    <div class="form-group">
        <div class="row">
            <div class="col-md-3">
                <label for="id">Идентификатор</label>
                <input id="id" class="form-control" name="id" type="text">
            </div>
        </div>
        <br>
        <div v-if="Object.keys(this.tableData).length > 0" class="row">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Дата</th>
                        <th scope="col">Комментарий</th>
                        <th scope="col">Что переводим</th>
                        <th scope="col">Результат</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th scope="row">{{ tableData.id }}</th>
                        <td>{{ tableData.date }}</td>
                        <td>{{ tableData.comment }}</td>
                        <td style="width : 250px">
                            {{
                                JSON.parse(tableData.data).targetMoneyAmount + ' ' +
                                getValuteName(JSON.parse(tableData.data).targetValute)
                            }}
                        </td>
                        <td style="width: 250px">
                            <div v-for="(data, index) in JSON.parse(tableData.data).selectElements.length">
                                {{ getValuteName(JSON.parse(tableData.data).selectElements[index]) + ' - ' }}
                                {{ JSON.parse(tableData.data).inputItems[index] }}
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-md-3">
                        <input id="comment" class="form-control" name="comment" type="text">
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary" @click="updateComment">Обновить комментарий</button>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <button id="submit" class="btn btn-primary" @click="find">Найти</button>
    </div>
</template>

<script>
export default {
    name: "ResultForm",
    props: ['valuteList'],
    data() {
        return {
            tableData: '',
        }
    },
    methods: {
        async find() {
            let id = document.getElementById('id').value;
            if (id.length === 0) {
                alert('Необходимо указать идентификатор');
                return
            }
            this.tableData = await axios.post('/history/get-result', {
                'id': id
            }).then(function (response) {
                return response.data
            });
        },
        getValuteName(name) {
            return this.valuteList.find(function (item) {
                if (item.char_code === name) {
                    return item.char_code;
                }
            }).name
        },
        updateComment() {
            let id = this.tableData.id;
            if (id.length === 0) {
                alert('Необходимо указать текст комментария');
                return
            }
            let comment = document.getElementById('comment').value;
            axios.post('history/update-comment', {
                'id': id,
                'comment': comment
            }).then(function (response) {
                if (response.data === 1) {
                    alert('Комментарий успешно обновлен')
                } else {
                    alert('Ошибка при обновлении комментария')
                }
            })
        },
    },
}
</script>

<style scoped>

</style>
