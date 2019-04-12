<template>
  <div>
    <div class="card-header">День: {{ day }}</div>
    <div class="card-body">
      <div class="container">
          <div class="row">
              <div class="col-md-6" v-for="(item, index) in corrals" :key="item.id">
                  <h3>Загон №{{ item.id }}</h3>
                  <div class="zagon">
                      <div class="name">{{ item.count }} овец</div>
                  </div>
              </div>
          </div>
      </div>
      <button @click="reset()">Reset</button>   
    </div>
    <div class="card-header">Отчет по дням</div>
    <div class="card-body">
      <table class="table">
  <thead>
    <tr>
      <th scope="col">Days</th>
      <th scope="col">Count</th>
      <th scope="col">Dead</th>
      <th scope="col">Alive</th>
      <th scope="col">Max corral</th>
      <th scope="col">Min corral</th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="item in days">
      <td>{{ item.day }}</td>
      <td>{{ item.count }}</td>

      <td>{{ item.dead }}</td>
      <td>{{ item.alive }}</td>

      <td>{{ item.max }}</td>
      <td>{{ item.min }}</td>
    </tr>
  </tbody>
</table>
    </div>
  </div>
</template>

<script>
export default {
  props: ["user"],
  data() {
    return {
      corrals: [],
      userId: this.user,
      day: "",
      days: []
    };
  },
  mounted() {
    this.getCorrals();
    setInterval(() => {
      this.getCorrals();
    }, 3000);
  },

  methods: {
    getCorrals() {
      axios.get(`/api/corrals/${this.userId}`).then(response => {
        this.corrals = response.data.data;
        this.day = response.data.day;
        this.days = response.data.days;
      });
    },
    reset() {
      axios
        .post(`/api/reset`, {
          user: this.userId
        })
        .then(response => {})
        .catch(e => {
          console.log(e);
        });
      this.getCorrals();
    }
  }
};
</script>
