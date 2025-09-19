<template>

  
      <div class="grid grid-cols-12 gap-6 px-6 py-6">
        <!-- Recent Threads (Right Side) -->
        <div class="col-span-9 order-2">
          <div  v-if="threads?.data && threads.data.length" class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold">Recent Threads</h2>
            <select v-model="filter" class="border rounded-md px-6 py-1 text-sm">
              <option value="latest">Latest</option>
              <option value="popular">Most Replies</option>
              <option value="followed">Followed Threads</option>
            </select>
          </div>

          <!-- Thread Card -->
          <div v-if="threads?.data && threads.data.length > 0" >
            <div v-for="thread in threads.data" :key="thread.id" class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow p-4">
          
              <div class="flex items-center gap-2 mb-2">
                  <!-- Avatar -->
                  <Link :href="route('users.show',thread.user.id)" 
                  class="w-7 h-7 bg-blue-100 rounded-full flex items-center justify-center">
                  <span class="text-blue-600 font-semibold text-sm">
                  {{ thread.user?.name ? thread.user.name.charAt(0).toUpperCase() : 'A' }}
                  </span>
                  </Link>

                  <!-- Category -->
                  <span class="text-xs bg-blue-100 text-blue-600 px-2 py-0.5 rounded">
                  {{ thread.category?.name }}
                  </span>

                  <!-- Time -->
                  <span class="text-xs text-gray-600">
                  {{ moment(thread.created_at,"YYYYMMDD").fromNow() }}
                  </span>
                </div>

              <Link prefetch :href="route('threads.show', thread.id)" class="block text-lg font-semibold mt-2 text-gray-800">{{ thread.title }}</Link>
              <p class="text-sm text-gray-600 mt-1 line-clamp-2">
                {{ thread.body }}
              </p>
            <div class="flex items-center justify-between text-sm text-gray-500 mt-3">
              <div>24 replies • 1.2k views</div>
              <div class="flex items-center gap-3">
              <span>by {{ thread.user.name }}</span>
            
            <Link :href="route('threads.edit', thread.id)"
            v-if="$page.props.auth?.user && thread.threadActionAuthorized"
            type="button"
            class="inline-flex items-center px-3 py-1.5 rounded-md text-sm font-medium text-blue-700 border border-blue-300 hover:bg-red-50 transition-colors"
            >
            Edit
            </Link>

            <button
            v-if="$page.props.auth?.user && thread.threadActionAuthorized"
            type="button"
            class="inline-flex items-center px-3 py-1.5 rounded-md text-sm font-medium text-red-700 border border-red-300 hover:bg-red-50 transition-colors"
            @click="openDeleteModal(thread)"
            >
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M15 7V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3" />
            </svg>
            Delete
            </button>
            
              </div>
            </div>
            </div>
          </div>   

          <div v-else class="bg-gradient-to-br from-white to-blue-50 border border-blue-100 rounded-xl shadow-sm">
            <div class="px-8 py-12 text-center">
              <div class="mx-auto mb-6 h-16 w-16 rounded-full bg-blue-100 flex items-center justify-center">
                <svg class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M21 16.5a2.5 2.5 0 01-2.5 2.5H7l-4 3V5.5A2.5 2.5 0 015.5 3h13A2.5 2.5 0 0121 5.5v11z" />
                </svg>
              </div>
              <h3 class="text-xl font-semibold text-gray-900">No threads yet</h3>
              <p class="mt-2 text-gray-600">Be the first to start a conversation and kick things off.</p>
              <div class="mt-6 flex items-center justify-center space-x-3">
                <Link v-if="$page.props.auth?.user" :href="route('threads.create')" class="inline-flex items-center px-4 py-2 rounded-md text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 shadow-sm">
                  <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                  </svg>
                  New Thread
                </Link>
                <Link v-else :href="route('login')" class="inline-flex items-center px-4 py-2 rounded-md text-sm font-medium text-blue-700 bg-white hover:bg-gray-50 border border-blue-200">
                  Sign in to post
                </Link>
              </div>
            </div>
          </div>
    </div>
    </div>

    


    <!-- pagination -->
    <!-- <WhenVisible 
      :params = "{
        only : ['threads'],
        data : {
          page : threads.current_page + 1
        }
      }" :always="this.threads.current_page < this.threads.last_page"
      >
        <template #fallback>
          <span>Load...</span>
        </template>

        
    </WhenVisible> -->

    <!-- Delete Confirmation Modal -->
    <Modal :show="showDeleteModal" @close="closeDeleteModal">
    <div class="p-6">
      <div class="sm:flex sm:items-start">
        <!-- Red warning icon -->
        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
          <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M15 7V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3" />
          </svg>
        </div>

        <!-- Text -->
        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
          <h3 class="text-lg leading-6 font-medium text-gray-900">Delete thread</h3>
          <div class="mt-2">
            <p class="text-sm text-gray-500">
              Are you sure you want to delete
              <span class="font-semibold text-gray-700">"{{ threadToDelete?.title }}"</span>?
              This action cannot be undone.
            </p>
          </div>
        </div>
      </div>
      <!-- Buttons -->
      <div class="mt-6 sm:mt-5 sm:flex sm:flex-row-reverse sm:space-x-reverse sm:space-x-3">
        <button
          type="button"
          class="inline-flex w-full justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:ml-3 sm:w-auto"
          @click="confirmDelete"
        >
          Delete
        </button>
        <button
          type="button"
          class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:mt-0 sm:w-auto"
          @click="closeDeleteModal"
        >
          Cancel
        </button>
      </div>
    </div>
</Modal>


</template>


<script>
import moment  from 'moment';
import {Link, WhenVisible} from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
export default {
    name : 'Welcome',
    
    components:{Link, Modal, WhenVisible},
    props : {
        threads: {
            type : Object
        }
    },
    data(){
        return{
          showDeleteModal: false,
          filter: 'latest',
          threadToDelete: null,
        }
    },
    watch: {
      filter(){
        this.$inertia.get('/?filter='+this.filter)
      }
    },
    methods:{
      moment,
      openDeleteModal(thread){
        this.threadToDelete = thread;
        this.showDeleteModal = true;
      },
      closeDeleteModal(){
        this.showDeleteModal = false;
        this.threadToDelete = null;
      },
      confirmDelete(){
        this.$inertia.delete(route('threads.destroy', this.threadToDelete.id))
        this.closeDeleteModal();
      }
    },
    



    mounted(){
      // if(this.threads.current_page !== 1){
      // this.$inertia.visit(route('home'), { data: { page: 1 }, replace: true, only: ['threads'] })
      // }
    }
}
</script>

<style>

</style>