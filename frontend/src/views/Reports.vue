<script lang="ts" setup>
import { ref, onMounted } from 'vue';
import axios from '../axios';

const sales = ref([]);
const selectedFormat = ref('json');

// Получение данных о покупках для отображения
const fetchSalesData = async () => {
    try {
        const response = await axios.get('/report');
        sales.value = response.data;
    } catch (error) {
        console.error('Ошибка при загрузке данных:', error);
    }
};

// Метод для скачивания отчета
const downloadReport = () => {
    const format = selectedFormat.value;
    const url = `/report?format=${format}`;

    axios({
        url: url,
        method: 'GET',
        responseType: 'blob', 
    })
        .then((response) => {
            const fileURL = window.URL.createObjectURL(new Blob([response.data]));
            const fileLink = document.createElement('a');
            const fileName = format === 'csv' ? 'report.csv' : 'report.json';

            fileLink.href = fileURL;
            fileLink.setAttribute('download', fileName);
            document.body.appendChild(fileLink);
            fileLink.click();
        })
        .catch((error) => {
            console.error('Ошибка при скачивании файла:', error);
        });
};


onMounted(() => {
    fetchSalesData();
});
</script>

<template>
    <div class="reports-container">
        <h1>Отчеты покупок</h1>

        <div class="download-section">
            <label for="file-format">Скачать:</label>
            <select v-model="selectedFormat" id="file-format">
                <option value="json">JSON</option>
                <option value="csv">CSV</option>
            </select>
            <button @click="downloadReport">Скачать</button>
        </div>

        <div class="report">
            <h2>Покупки за последний месяц</h2>
            <table v-if="sales.length > 0">
                <thead>
                    <tr>
                        <th>Дата</th>
                        <th>Количество покупок</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="sale in sales" :key="sale.date">
                        <td>{{ sale.date }}</td>
                        <td>{{ sale.purchase_count }}</td>
                    </tr>
                </tbody>
            </table>
            <p v-else>Нет данных о покупках за последний месяц.</p>
        </div>
    </div>
</template>



<style scoped>
.reports-container {
    padding: 20px;
    background-color: #f4f4f4;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

h1 {
    margin-bottom: 20px;
}

.download-section {
    margin-bottom: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th,
td {
    border: 1px solid #ccc;
    padding: 10px;
    text-align: left;
}

th {
    background-color: #e9e9e9;
}

button {
    padding: 10px 15px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}
</style>