import { ref } from 'vue'

export default {
    install(app) {
        const socket = ref(null)
        const isConnected = ref(false)
        const eventQueue = []

        const initWebSocket = () => {
            if (socket.value && socket.value.readyState <= 1) {
                socket.value.close()
            }

            socket.value = new WebSocket(import.meta.env.VITE_WS_URL)

            socket.value.onopen = () => {
                console.log('WebSocket connection established')
                isConnected.value = true
                // Send all queued events
                while (eventQueue.length > 0) {
                    const event = eventQueue.shift()
                    socket.value.send(JSON.stringify(event))
                }
            }

            socket.value.onclose = () => {
                console.log('WebSocket connection closed')
                isConnected.value = false
                // Try to reconnect after 5 seconds
                setTimeout(initWebSocket, 5000)
            }

            socket.value.onerror = (error) => {
                console.error('WebSocket error:', error)
                isConnected.value = false
            }
        }

        const sendEvent = (name, props) => {
            if (isConnected.value && socket.value.readyState === WebSocket.OPEN) {
                socket.value.send(JSON.stringify({ id: Date.now(), name, props }))
            } else {
                eventQueue.push({ id: Date.now(), name, props })
            }
        }

        app.config.globalProperties.$eventTracker = {
            sendEvent,
            isConnected,
        }

        initWebSocket()
    },
}