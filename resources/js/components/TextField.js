import React from 'react';
import TextField from '@material-ui/core/TextField';


export default ({
    error,
    required = true,
    label,
    name,
    handleChange,
    handleBlur,
    value,
    type = "text",
    InputLabelProps
}) => {

   return (
          <TextField
            type={type}
            error={!!error}
            helperText={error}
            variant="outlined"
            required={required}
            id={name}
            InputLabelProps={InputLabelProps}
            name={name}
            label={label}
            value={value|| ''}
            onChange={handleChange}
            onBlur={handleBlur}
            fullWidth
          />
   )
}

