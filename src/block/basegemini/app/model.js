import React from 'react'
import {  
  useLazyGetModelByNameQuery 
} from './store/async';

export default props => {

  const [
    getModel, 
    {       
      data, 
      isError,
      isFetching,
      isLoading,
      isSuccess,
      isUninitialized,
      status
    }
  ] = useLazyGetModelByNameQuery()

  return <div className="model">
    <div className="status">
      <button onClick={ () => getModel('models/embedding-gecko-001') }>
        get model
      </button>
      <div className="text">
        { status }
      </div>
    </div>
    <div className="data">
      {
        data && 
        Object.keys(data)
        .map(
          (key, index) => <div 
            key={ index }
            className="field"
          >
            <span>{ key }</span>
            { ' -> ' }
            <span>{ data[key] }</span>
          </div>
        )
      }
    </div>
  </div>
}
