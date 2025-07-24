import { configureStore } from '@reduxjs/toolkit'

import counterReducer from './counterslice'
import { geminiApi } from './async'

export const store = configureStore({
  reducer: {
    counter: counterReducer,
    [geminiApi.reducerPath]: geminiApi.reducer
  },
  middleware: (getDefaultMiddleware) =>
    getDefaultMiddleware().concat(geminiApi.middleware)
})