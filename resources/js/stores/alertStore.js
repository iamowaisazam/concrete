import { defineStore } from 'pinia'

export const useAlertStore = defineStore('alert', {
  state: () => ({
    queue: [], // List of queued alerts
    current: null, // The alert currently showing
    show: false, // Snackbar visibility
  }),

  actions: {
    // Add new alert
    add(message, type = 'info', timeout = 3000) {
      const colors = {
        success: '#28A745',
        error: '#DC3545',
        warning: '#FFC107',
        info: '#007BFF'
      }

      const color = colors[type] || 'gray'
      this.queue.push({ message, color, timeout })
      if (!this.show) this.next()
    },

    // Show the next alert in the queue
    next() {
      if (this.queue.length === 0) {
        this.show = false
        this.current = null
        return
      }

      this.current = this.queue.shift()
      this.show = true

      // Hide after timeout, then show next
      setTimeout(() => {
        this.show = false
        setTimeout(() => this.next(), 300) // short delay between alerts
      }, this.current.timeout)
    },

    clear() {
      this.queue = []
      this.current = null
      this.show = false
    },
  },
})
