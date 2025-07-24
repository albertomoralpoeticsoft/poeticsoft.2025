import React from 'react'
import {  
  useLazyGetModelsQuery 
} from './store/async';

export default props => {

  const [
    getModels, 
    {       
      data, 
      isError,
      isFetching,
      isLoading,
      isSuccess,
      isUninitialized,
      status
    }
  ] = useLazyGetModelsQuery()

  const goModel = name => {

    console.log(name)
  }

  return <div className="models">
    <div className="status">
      <button onClick={ () => getModels() }>
        get models
      </button>
      <div className="text">
        { status }
      </div>
    </div>
    <div className="list">
      {
        data && 
        data
        .map(
          (model, index) => <div 
            key={ index }
            className="modelname"
          >
            <a 
              className="gomodel"
              onClick={ () => goModel(model.name) }
            >
              { model.displayName }
            </a>
          </div>
        )
      }
    </div>    
  </div>
}
