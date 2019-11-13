<template>
  <div>
    <!--ログインしている場合-->
    <div v-if="isLogin">
      <el-container>
        <el-aside width="200px">
          <div>
            <div style="margin: 40px;">
              <router-link to="/" style="display: block;" class="mb-3">Home</router-link>
              <router-link to="/app_index" style="display:block;" class="mb-3">アプリケーション一覧</router-link>
              <!--<router-link to="/" @click="logout">Logout</router-link>-->
              <p>today</p>
              <p>news</p>
              <p>create newb board</p>
              <p>recently read</p>
              <p>intergration</p>
            </div>
          </div>
        </el-aside>
        <el-main>
          <div>
            <router-view></router-view>
          </div>
        </el-main>
      </el-container>
    </div>
    <!--ここまでログインしている場合-->
    
    <!--ログインしていない場合-->
    <div v-else>
      <div class="container--small">
        
        <!--ログイン-->
        <el-card class="box-card login" v-show="tab === 1">
          <div slot="header" class="clearfix">
            <span>Login</span>
            <el-button style="float: right; padding: 3px 0" type="text">Forget password</el-button>
          </div>
        
          <el-form label-width="80px">
            <el-form-item label="Email">
              <el-input v-model="loginForm.email"></el-input>
            </el-form-item>
            <el-form-item label="Password">
              <el-input type="password" v-model="loginForm.password"></el-input>
            </el-form-item>
            <el-form-item>
              <el-button 
                style="float: left; cursor: pointer;" 
                class="tab__item"
                :class="{'tab__item--active': tab === 2 }"
                @click="tab = 2">register</el-button>
              <el-button style="float: right" type="primary" @click="login">Login</el-button>
            </el-form-item>
          </el-form>
          
          <!--バリデートエラー-->
          <el-container v-if="loginErrors" class="errors">
            <el-container v-if="loginErrors.email">
              <el-alert type="error" v-for="msg in loginErrors.email" :key="msg">{{ msg }}</el-alert>
            </el-container>
            <el-container v-if="loginErrors.password">
              <el-alert type="error" v-for="msg in loginErrors.password" :key="msg">{{ msg }}</el-alert>
            </el-container>
          </el-container>
          <!--ここまでバリデートエラー-->
        </el-card>
        <!--ここまでログイン-->
      
        <!--登録-->
        <el-card class="box-card register" v-show="tab === 2">
          <div slot="header" class="clearfix">
            <span>Register</span>
            <el-button style="float: right; padding: 3px 0" type="text">Forget password</el-button>
          </div>
        
          <el-form label-width="80px">
            <el-form-item label="Name">
              <el-input v-model="registerForm.name"></el-input>
            </el-form-item>
            <el-form-item label="Email">
              <el-input v-model="registerForm.email"></el-input>
            </el-form-item>
            <el-form-item label="Password">
              <el-input type="password" v-model="registerForm.password"></el-input>
            </el-form-item>
            <el-form-item label="Password">
              <el-input type="password" v-model="registerForm.password_confirmation"></el-input>
            </el-form-item>
            <el-form-item>
              <el-button
                style="float: left; cursor: pointer;" 
                class="tab__item"
                :class="{'tab__item--active': tab === 1 }"
                @click="tab = 1">Login</el-button>
              <el-button style="float: right" type="primary" @click="register">Register</el-button>
            </el-form-item>
          </el-form>
          
          <!--バリデートエラー-->
          <el-container v-if="registerErrors" class="errors">
            <el-container v-if="registerErrors.name">
              <el-alert type="error" v-for="msg in registerErrors.name" :key="msg">{{ msg }}</el-alert>
            </el-container>
            <el-container v-if="registerErrors.email">
              <el-alert type="error" v-for="msg in registerErrors.email" :key="msg">{{ msg }}</el-alert>
            </el-container>
            <el-container v-if="registerErrors.password">
              <el-alert type="error" v-for="msg in registerErrors.password" :key="msg">{{ msg }}</el-alert>
            </el-container>
          </el-container>
        </el-card>
        <!--ここまでバリデートエラー-->
      </div>
      <!--ここまで登録-->
    </div>
    <!--ここまでログインしていない場合-->

  </div>
</template>

<script>
import { mapState, mapGetters } from 'vuex'

export default {
  data () {
    return {
      tab: 1,
      loginForm: {
        email: '',
        password: ''
      },
      registerForm: {
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
      },
    }
  },
  methods: {
    async login () {
      // authストアのloginアクションを呼び出す
      await this.$store.dispatch('auth/login', this.loginForm)
    
      if (this.apiStatus) {
        // トップページに移動する
        this.$router.push('/app_index/')
      }
    },
    async register () {
      // authストアのresigterアクションを呼び出す
      await this.$store.dispatch('auth/register', this.registerForm)

      if (this.apiStatus) {
        // トップページに移動する
        this.$router.push('/app_index/')
      }
    },
    async logout () {
      await this.$store.dispatch('auth/logout')

      if (this.apiStatus) {
        this.$router.push('/')
      }
    },
    clearError () {
    this.$store.commit('auth/setLoginErrorMessages', null)
    this.$store.commit('auth/setRegisterErrorMessages', null)
    },
  },
  created: function () {
    this.clearError()
  },
  computed: {
    apiStatus () {
      return this.$store.state.auth.apiStatus
    },
    isLogin () {
      return this.$store.getters['auth/check']
    },
    username () {
      return this.$store.getters['auth/username']
    },
    loginErrors () {
      return this.$store.state.auth.loginErrorMessages
    },
    registerErrors () {
      return this.$store.state.auth.registerErrorMessages
    },
    ...mapGetters({
      isLogin: 'auth/check'
    })
  }
}
</script>