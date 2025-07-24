import { 
  createSlice,
  createAsyncThunk
} from '@reduxjs/toolkit'

const initialState = {
  value: 0,
  status: 'idle'
}

// Acción asincrónica simulada
export const fetchRandomNumber = createAsyncThunk(
  'counter/fetchRandomNumber',
  async () => {

    const response = await new Promise(
      (resolve) => { 

        setTimeout(() => {
          
          resolve(Math.floor(Math.random() * 100))

        }, 1000)
      }
    );

    return response;
  }
);

export const counterSlice = createSlice({
  name: 'counter',
  initialState,
  reducers: {

    increment: (state) => {

      state.value += 1
    },

    decrement: (state) => {
      
      state.value -= 1
    },

    incrementByAmount: (state, action) => {

      state.value += action.payload
    },
  },

  extraReducers: (builder) => {

    builder
    .addCase(
      fetchRandomNumber.pending,
      state => {
        state.status = 'loading';
      }
    )
    .addCase(
      fetchRandomNumber.fulfilled, 
      (state, action) => {
        state.status = 'succeeded';
        state.value = action.payload;
      }
    )
    .addCase(
      fetchRandomNumber.rejected, 
      state => {
        state.status = 'failed';
      }
    );
  }
})

export const { increment, decrement, incrementByAmount } = counterSlice.actions

export default counterSlice.reducer