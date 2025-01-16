FROM node:20-alpine

WORKDIR /app

# Install dependencies
COPY package*.json ./

# Clean install dependencies with legacy-peer-deps
RUN npm install --legacy-peer-deps

# Start development server
CMD ["npm", "run", "dev", "--", "--host"] 