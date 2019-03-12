var app = new Vue({
  el: '#app',
  data: {
    actors: [],
    name: '',
    surname: '',
    id : 1
  },
  methods: {
  	onAddActor () {
  		if (this.name === '' || this.surname === '') {
  			alert("Заполните поля: имя и фамилия актера")
  		} else {
  			this.actors.push({
  				name: this.name,
  				surname: this.surname,
  				id: this.id++,
  			})
  			this.name = '';
  			this.surname = '';
  		}
  	},
  	deleteActor(id) {
  		this.actors.splice(this.actors.indexOf(id), 1);
  	},
  	onSubmit()
  	{
  		this.actors.forEach((actor) => {
  			$("#actors-hidden").append("<input type='hidden' name=actors[" + actor.id + "][name] value='" + actor.name + "'>");
  			$("#actors-hidden").append("<input type='hidden' name=actors[" + actor.id + "][surname] value='" + actor.surname + "'>");
  		});
  	},
    onSortChange()
    {
      var sort = $("#sort").val();
      document.location.href = '/list?sort=' + sort;
    }
  }
})
