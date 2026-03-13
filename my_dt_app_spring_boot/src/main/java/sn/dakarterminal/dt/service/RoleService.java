package sn.dakarterminal.dt.service;

import lombok.RequiredArgsConstructor;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;
import sn.dakarterminal.dt.dto.RoleDto;
import sn.dakarterminal.dt.entity.Role;
import sn.dakarterminal.dt.exception.ResourceNotFoundException;
import sn.dakarterminal.dt.repository.RoleRepository;

import java.util.List;
import java.util.stream.Collectors;

@Service
@RequiredArgsConstructor
@Transactional(readOnly = true)
public class RoleService {

    private final RoleRepository roleRepository;

    public List<RoleDto> findAll() {
        return roleRepository.findAll().stream()
                .map(this::toDto)
                .collect(Collectors.toList());
    }

    public RoleDto findById(Long id) {
        Role role = roleRepository.findById(id)
                .orElseThrow(() -> new ResourceNotFoundException("Role not found with id: " + id));
        return toDto(role);
    }

    private RoleDto toDto(Role role) {
        return RoleDto.builder()
                .id(role.getId())
                .name(role.getName())
                .build();
    }
}
