<template>
    <div class="min-h-screen bg-white">
      <!-- Header -->
      <div class="border-b px-6 py-4 flex items-center justify-between">
        <Link :href="route('home')">
            <h1 class="text-2xl font-semibold">CC Forum</h1>
        </Link>
        <div class="flex items-center gap-3">
          <Link v-if="$page.props.auth.user" href="/new-thread" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
            New Thread
          </Link>
          <input
            type="text"
            placeholder="Search forums..."
            class="border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
            v-model="search"
          />
          <template v-if="!$page.props.auth.user">
            <Link href="/login" class="border-blue-600 border text-black px-4 py-2 rounded-md">
            Login
          </Link>
          <Link href="/register" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
            Register
          </Link>
          </template>
          <template v-else>
            <Link v-if="$page.props.auth.user" 
              href="/logout" 
              method="post" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
            Logout
          </Link>
          </template>
          
        </div>
      </div>
  
      <div class="grid grid-cols-12 gap-6 px-6 py-6">
        <!-- Recent Threads (Right Side) -->
        <div class="col-span-9 order-2">
          <slot />
        </div>
  
        <!-- Categories (Left Side with Card Style) -->
        <div class="col-span-3 order-1 space-y-6">
          <!-- Categories Card -->
          <div class="border rounded-md p-4 bg-white shadow-sm">
            <h2 class="text-lg font-semibold mb-4">Categories</h2>
            <ul class="space-y-4">
              <Link :href="'/?category='+category.slug" v-for="category in $page.props.categories" :key="category.id" class="flex flex-col">

              <!-- Top row: name + count -->
                <div class="flex justify-between items-center">
                  <span class="flex items-center gap-2 font-semibold">
                  <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                  {{ category.name }}
                  </span>
                  <span class="text-gray-500 text-sm">1.2k</span>
                </div>

                <!-- Description -->
                <p class="text-gray-600 text-sm ml-5">
                {{ category.description }}
                </p>

              </Link>
            </ul>
          </div>
  
          <!-- Popular Tags Card -->
          <div class="border rounded-md p-4 bg-white shadow-sm">
            <h2 class="text-lg font-semibold mb-4">Popular Tags</h2>
            <div class="flex flex-wrap gap-2">
              <Link :href="route('home', {
                tag : tag.slug
              })" v-for="tag in $page.props.tags" :key="tag.id"  class="px-3 py-1 bg-gray-100 rounded-md text-sm text-gray-700">{{ tag.name }}</Link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>


<script>
import {Link} from '@inertiajs/vue3';
export default {
    name : 'Welcome',
    components : {Link},
    props : {
        threads: {
            type : Array
        }
    },
    data(){
        return{
            search : ""
        }
    },
    watch : {
      search(){
        this.$inertia.get(route('home', {
          search : this.search
        }))
      }
    },
    
    mounted(){
        console.log(this.$page.props.categories);
    }
}
</script>

<style>

</style>