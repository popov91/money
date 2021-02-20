<template>
    <div>
        <div class="form-group">
            <div class="row" style="margin-bottom: 10px">
                <div class="col-md-3">
                    <label for="target_valute">Что переводим</label>
                    <select id="target_valute" v-model="valutes[0].char_code" class="form-control" name="valute_in">
                        <option v-for="valute in valutes" :value="valute.char_code">{{ valute.name }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="target_money_amount">Сумма</label>
                    <input id="target_money_amount" class="form-control" name="money_amount_in" type="text">
                </div>
                <div class="col-md-3">
                    <label for="date">На какую дату</label>
                    <input id="date" class="form-control" name="date" type="date">
                </div>
            </div>
            <p>Куда переводим</p>
            <div>
                <div v-for="(element, index) in elements" class="row" style="margin-top: 10px">
                    <div class="col-md-3">
                        <select :id="'valute_out-' + index" v-model="valutes[0].char_code"
                                :name="'valute_out[' + index + ']'" class="form-control valute">
                            <option v-for="valute in valutes" :value="valute.char_code">
                                {{ valute.name }}
                            </option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input :id="'money_amount_out-' + index" :name="'money_amount_out[' + index + ']'"
                               class="form-control"
                               disabled type="text">
                    </div>
                </div>
                <input class="btn btn-primary" style="margin-top: 10px" type="button" value="Добавить валюту"
                       @click="increment">
                <input class="btn btn-primary" style="margin-top: 10px" type="button" value="Убрать валюту"
                       @click="decrement">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <input id="comment" class="form-control" name="comment" placeholder="Комментарий к выборке" type="text">
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-3">
                <button id="calc" class="btn btn-success" type="button" @click="calculate">Посчитать</button>
            </div>
            <div class="col-md-3">
                <button id="save" class="btn btn-success" type="button" @click="saveData">Сохранить выборку</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['valutes'],
    data() {
        return {
            elements: 1,
        }
    },
    methods: {
        increment() {
            this.elements++;
        },
        decrement() {
            if (this.elements === 1) {
                return
            }
            this.elements--;
        },
        calculate() {
            let elementsCount = document.getElementsByClassName('valute').length;
            let targetValute = document.getElementById('target_valute').value;
            let targetMoneyAmount = document.getElementById('target_money_amount').value;
            if (targetMoneyAmount.length === 0) {
                alert('Необходимо указать сумму')
                return
            }

            let date = document.getElementById('date').value;
            let selectElements = [];
            let inputItems = [];
            for (let i = 0; i < elementsCount; i++) {
                selectElements.push(document.getElementById('valute_out-' + i).value);
                inputItems.push(document.getElementById('money_amount_out-' + i));
            }

            axios.post('/calculate/send-to-calculate', {
                'targetValute': targetValute,
                'targetMoneyAmount': targetMoneyAmount,
                'selectElements': selectElements,
                'date': date
            }).then(function (response) {
                let data = response.data;
                data.forEach(function (item, i) {
                    inputItems[i].value = item.toFixed(4);
                })
            });
        },
        saveData() {
            let elementsCount = document.getElementsByClassName('valute').length;

            let selectElements = [];
            let inputItems = [];
            for (let i = 0; i < elementsCount; i++) {
                selectElements.push(document.getElementById('valute_out-' + i).value);
                inputItems.push(document.getElementById('money_amount_out-' + i).value);
            }

            let data = {
                'targetValute': document.getElementById('target_valute').value,
                'targetMoneyAmount': document.getElementById('target_money_amount').value,
                'selectElements': selectElements,
                'inputItems': inputItems
            }

            axios.post('/calculate/save-result', {
                'comment': document.getElementById('comment').value,
                'date': document.getElementById('date').value,
                'data': data
            }).then(function (response) {
                alert('Идентификатор вашего результата - ' + response.data)
            })
        }
    }
}
</script>
