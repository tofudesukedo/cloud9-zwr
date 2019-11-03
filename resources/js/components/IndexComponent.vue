<template>
  <div class="index" style="text-align: center;">
    <div class="app-content">
        <ul class="app-header">
          <li>
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">追加</button>
            <span class="btn btn-primary">CSVファイル</span>
          </li>
          <li><input type="text" class="search-query span3" placeholder="Search"></li>
        </ul>
        <div>
           <h1>アプリケーション</h1>
           <table class="table table-hover">
               <thead>
               <tr>
                   <th>ID</th>
                   <th>Name</th>
                   <th>Edit</th>
                   <th>Delete</th>
               </tr>
               </thead>
               <tbody>
                   <tr @click="detailShow()" v-for="app in apps" :key="app.id">
                       <td>{{ app.id }}</td>
                       <td>{{ app.title }}</td>
                       <td><button class="btn btn-success" data-toggle="modal" data-target="#editModal">Edit</button></td>
                       <td><button class="btn btn-danger" @click.prevent="deleteApp(app.id)">Delete</button></td>
                   </tr>
               </tbody>
           </table>
       </div>
       
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">アプリケーションの追加</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form @submit.prevent="addApp">
              <div class="modal-body">
               <div class="row">
                   <div class="col-md-12">
                       <div class="form-group">
                           <label>App Title:</label>
                           <input type="text" class="form-control" v-model="app.title">
                       </div>
                   </div>
               </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="form-group btn btn-primary">Save changes</button>
              </div>
              </form>
            </div>
          </div>
        </div>
        
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">アプリケーションの編集</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form @submit.prevent="editApp">
              <div class="modal-body">
               <div class="row">
                   <div class="col-md-12">
                       <div class="form-group">
                           <label>App Title:</label>
                           <input type="text" class="form-control" v-model="app.title">
                       </div>
                   </div>
               </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="form-group btn btn-primary">Save changes</button>
              </div>
              </form>
            </div>
          </div>
        </div>
    </div>
    
    <div class="app-detail" style="background: #f6f7f8; height: 700px; width:400px">
        <div class="row">
            <button @click="closeDetail" type="button" class="close" style="height:30px;" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
            </button>
            <div style="margin: 40px; text-align:center; word-break: break-all">
                <h2>基本情報</h2>
                <p></p>oooooooooooooooooooooooooooooooooooooooooooo</p>
                <h2>ドメイン情報</h2>
                <p>oooooooooooooooooooooooooooooooooooooooooooo</p>
                <h2>ドメイン情報</h2>
                <p>oooooooooooooooooooooooooooooooooooooooooooo</p>
            </div>
        </div>
    </div>
  </div>
</template>

<script>
export default{
  data() {
       return {
          apps: [],
          app:{}
       }
  },
  mounted: function(){
      const uri = "/api" + this.$route.path;
      this.axios.get(uri).then(response => {
        this.apps = response.data.apps;
         console.log(this.apps);
      });
  },
  methods: {
      addApp(){
           const uri = '/api/app_create';
           this.axios.post(uri, this.app).then((response) => {
               this.apps.push(response.data.app)
               console.log();
           });
        },
        editApp(id){
         const uri = `/api/app_edit/${id}`;
           this.axios.get(uri, this.app).then((response) => {
           console.log(response.data);
         });
        },
     deleteApp(id)
     {
         const uri = `/api/app_delete/${id}`;
         this.axios.delete(uri).then(response => {
         this.apps.splice(this.apps.indexOf(id), 1);
         });
     },
     detailShow: function() {
        $('.app-detail').addClass("active");
    },
    closeDetail: function() {
        $('.app-detail').removeClass("active");
    },
}
}
</script>
