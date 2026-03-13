package sn.dakarterminal.dt.service;

import lombok.RequiredArgsConstructor;
import lombok.extern.slf4j.Slf4j;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;
import sn.dakarterminal.dt.dto.RoleDto;
import sn.dakarterminal.dt.dto.UserCreateDto;
import sn.dakarterminal.dt.dto.UserDto;
import sn.dakarterminal.dt.entity.Role;
import sn.dakarterminal.dt.entity.User;
import sn.dakarterminal.dt.exception.ResourceNotFoundException;
import sn.dakarterminal.dt.repository.RoleRepository;
import sn.dakarterminal.dt.repository.UserRepository;

import java.util.List;
import java.util.stream.Collectors;

@Slf4j
@Service
@RequiredArgsConstructor
@Transactional
public class UserService {

    private final UserRepository userRepository;
    private final RoleRepository roleRepository;
    private final PasswordEncoder passwordEncoder;

    @Transactional(readOnly = true)
    public List<UserDto> findAll() {
        return userRepository.findAllActiveWithRole().stream()
                .map(this::toDto)
                .collect(Collectors.toList());
    }

    @Transactional(readOnly = true)
    public UserDto findById(Long id) {
        User user = userRepository.findById(id)
                .orElseThrow(() -> new ResourceNotFoundException("User not found with id: " + id));
        return toDto(user);
    }

    @Transactional(readOnly = true)
    public UserDto findByEmail(String email) {
        User user = userRepository.findByEmail(email)
                .orElseThrow(() -> new ResourceNotFoundException("User not found with email: " + email));
        return toDto(user);
    }

    public UserDto create(UserCreateDto dto) {
        if (userRepository.existsByEmail(dto.getEmail())) {
            throw new IllegalArgumentException("Email already in use: " + dto.getEmail());
        }

        User user = User.builder()
                .name(dto.getName())
                .email(dto.getEmail())
                .password(passwordEncoder.encode(dto.getPassword()))
                .twoFactorEnabled(dto.getTwoFactorEnabled() != null ? dto.getTwoFactorEnabled() : false)
                .actif(true)
                .build();

        if (dto.getRoleId() != null) {
            Role role = roleRepository.findById(dto.getRoleId())
                    .orElseThrow(() -> new ResourceNotFoundException("Role not found with id: " + dto.getRoleId()));
            user.setRole(role);
        }

        return toDto(userRepository.save(user));
    }

    public UserDto update(Long id, UserCreateDto dto) {
        User user = userRepository.findById(id)
                .orElseThrow(() -> new ResourceNotFoundException("User not found with id: " + id));

        user.setName(dto.getName());
        if (dto.getPassword() != null && !dto.getPassword().isBlank()) {
            user.setPassword(passwordEncoder.encode(dto.getPassword()));
        }
        if (dto.getTwoFactorEnabled() != null) {
            user.setTwoFactorEnabled(dto.getTwoFactorEnabled());
        }
        if (dto.getRoleId() != null) {
            Role role = roleRepository.findById(dto.getRoleId())
                    .orElseThrow(() -> new ResourceNotFoundException("Role not found with id: " + dto.getRoleId()));
            user.setRole(role);
        }

        return toDto(userRepository.save(user));
    }

    public void deactivate(Long id) {
        User user = userRepository.findById(id)
                .orElseThrow(() -> new ResourceNotFoundException("User not found with id: " + id));
        user.setActif(false);
        userRepository.save(user);
    }

    public void delete(Long id) {
        userRepository.findById(id)
                .orElseThrow(() -> new ResourceNotFoundException("User not found with id: " + id));
        userRepository.deleteById(id);
    }

    public UserDto toDto(User user) {
        RoleDto roleDto = null;
        if (user.getRole() != null) {
            roleDto = RoleDto.builder()
                    .id(user.getRole().getId())
                    .name(user.getRole().getName())
                    .build();
        }
        return UserDto.builder()
                .id(user.getId())
                .name(user.getName())
                .email(user.getEmail())
                .role(roleDto)
                .twoFactorEnabled(user.getTwoFactorEnabled())
                .emailVerifiedAt(user.getEmailVerifiedAt())
                .actif(user.getActif())
                .createdAt(user.getCreatedAt())
                .updatedAt(user.getUpdatedAt())
                .build();
    }
}
